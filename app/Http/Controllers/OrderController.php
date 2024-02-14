<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SellerCourierController;
use App\Models\buy_together;
use App\Models\Buyer;
use App\Models\Catagory;
use App\Models\ExtraCharge;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\SellerCurierCharges;
use App\Models\SellerExtraCharges;
use App\Models\SubCatagory;
use App\Models\WholesalePrice;
use App\Models\wirehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    function Orders(Request $request)
    {

if($request->order_status=="all"){


        $order_all = Order::where(["seller_id"=>$request->user()->id])->whereBetween("date",[$request->filter_from,$request->filter_to])->get();



        $formated_data=array();
        foreach ($order_all as $data){

            $image=ProductImage::where("product_id",$data->product_id)->first()["img"];

            $price=$data->amount;

            array_push($formated_data,["order_id"=>$data->order_id,"image"=>config("app.url")."storage/products/".$image,"item_count"=>$data->product_id,"grand_total"=>$price,"payment_method"=>$data->payment_status,"order_status"=>$data->order_status_seller,"created_at"=>date_format($data->created_at,"M d,h:m A")]);
        }
        return Response::json([
            "error" => false,
            "data" => $formated_data
        ]);

}else{
            $order_all = Order::where(["seller_id"=>$request->user()->id,"status"=>$request->order_status])->whereBetween("date",[$request->filter_from,$request->filter_to])->get();

        $formated_data=array();
        foreach ($order_all as $data){
            $image=ProductImage::whereIn("product_id",json_decode($data->product_id))->first()["img"];
            array_push($formated_data,["order_id"=>$data->order_id,"image"=>config("app.url")."storage/products/".$image,"item_count"=>count(json_decode($data->product_id)),"grand_total"=>$data->amount-$data->disc_amount,"payment_method"=>$data->payment_type,"order_status"=>$data->status,"created_at"=>date_format($data->created_at,"M d,h:m A")]);
        }
        return Response::json([
            "error" => false,
            "data" => $formated_data
        ]);
}

    }
    function OrderDetails($id,Request $request){

        $wirehouse=wirehouse::where("country",$request->user()->country)->first();

        Order::where("order_id",$id)->update([
            "wirehouse_id"=>$wirehouse->id
        ]);
        $order_all = Order::where("order_id",$id)->first();
        if($order_all!=null){
            $order_details=[];

            $all_orders=Order::where("order_id",$id)->get();

            $coupon_code=null;
            if(json_decode($order_all->coupon_info)!=null){
                $coupon_code=json_decode($order_all->coupon_info)->coupon_code;
            }

            $order_details["summery"]=[
                "id"=>$order_all->id,
                "order_id"=>$order_all->order_id,
                "item_count"=>count($all_orders),
                "item_total"=>Order::where("order_id",$id)->sum("quantity"),
                "delivery_fee"=>0,
                "coupon_code"=>null,
                "coupon_discount"=>0,
                "grand_total"=>$order_all->amount,
                "total"=>$order_all->amount,
                "payment_method"=>"",
                "order_status"=>$order_all->order_status_seller,
                "delivery_time"=>$order_all->delivery_time,
                "order_date"=>$order_all->date,
                "updated_at"=>$order_all->updated_at,
                "created_at"=>$order_all->created_at,
                "seller"=>$order_all->seller_id,
                "customer"=>$order_all->buyer_id,
            ];


            $Product_details=array();


            for($a=0; $a<count($all_orders); $a++){
                $p_info=Product::where("id",$all_orders[$a]->product_id)->first();
                array_push($Product_details,
                    [
                        "id"=>$all_orders[$a]->product_id,
                        "item_name"=>$p_info->product_name,
                        "quantity"=>$all_orders[$a]->quantity,
                        "unit_price"=>$all_orders[$a]->product_price,
                        "subtotal"=>$all_orders[$a]->amount,
                        "color"=>config("app.url")."storage/varients/".json_decode($all_orders[$a]->varient_info)[0]->color,
                        "size"=>json_decode($all_orders[$a]->varient_info)[0]->size

                    ]


                );
            }





            $order_details["products"]=$Product_details;


            $buyer_info=Buyer::where("id",$order_all->buyer_id)->first();


            $order_details["customer"]=[
                "name"=>$wirehouse->name,
                "mobile_number"=>$wirehouse->number,
                "country"=>$wirehouse->country,
                "address"=>$wirehouse->address,
                "city"=>$wirehouse->city,
                "postcode"=>$wirehouse->postcode,
            ];

            return Response::json([
                "error" => false,
                "data" => $order_details
            ]);
        }else{
            return Response::json([
                "error" => false,
                "msg" => "NO Data Found"
            ]);
        }




    }

    function Approve(Request $request){

        $time=date('Y-m-d h:i:s', strtotime('+'.$request->delivery_time.' minute'));

        Order::where("order_id",$request->order_id)->update([
            "delivery_time"=>$time,
            "order_status_seller"=>"Accepted",
            "order_status_user"=>"Accepted"
        ]);
        $order=Order::where("order_id",$request->order_id)->first();

        return response()->json([
            "error"=>false,
            "msg"=>"successfully Order Approved"

        ]);
    }
    function Reject(Request $request){
        Order::where("order_id",$request->order_id)->update([
            "order_status_seller"=>"Rejected",
            "order_status_user"=>"Rejected"
        ]);
        $order=Order::where("order_id",$request->order_id)->first();

        return response()->json([
            "error"=>false,
            "msg"=>"successfully Order Rejected"
        ]);
    }
    function Shiped(Request $request){
        Order::where("order_id",$request->order_id)->update([
            "order_status_seller"=>"Shipped"
        ]);


        return response()->json([
            "error"=>false,
            "msg"=>"successfully Order Shipped"
        ]);
    }
    function Faild(Request $request){
        Order::where("order_id",$request->order_id)->update([
            "order_status_seller"=>"Failed"
        ]);
        $order=Order::where("order_id",$request->order_id)->first();

        return response()->json([
            "error"=>false,
            "msg"=>"successfully Order Failed"
        ]);
    }
    function Complete(Request $request){
        Order::where("order_id",$request->order_id)->update([
            "order_status_seller"=>"Completed"
        ]);
        $order=Order::where("order_id",$request->order_id)->first();

        return response()->json([
            "error"=>false,
            "msg"=>"successfully Order Complete"
        ]);
    }
       function Delivered(Request $request){
        $data=Order::where("order_id",$request->order_id)->first();

        $p_weight=json_decode($data->unit_weight);
        $p_courier_charge=0;
        $courier_info=SellerCurierCharges::where("id",$request->courier_info["id"])->first();

        if($data->amount>$courier_info->above_amount){
            $p_courier_charge=$courier_info->charge;
        }

        $price=$p_courier_charge*$p_weight;


        $info=array();
        array_push($info,$request->courier_info);

        Order::where("order_id",$request->order_id)->update([
            "order_status_seller"=>"Delivered",
            "seller_delivery_info"=>json_encode($info),
            "seller_delivery_charge"=>$price
        ]);
        $order=Order::where("order_id",$request->order_id)->first();

        return response()->json([
            "error"=>false,
            "msg"=>"successfully Order Delivered"
        ]);
    }


    function TrackOrder($id){

        $order_info=Order::where("order_id",$id)->first();
        if($order_info!=null){

            $ship_info=json_decode($order_info->shipping_info)[0];


            $order_status=OrderTracking::where(["order_id"=>$id])->get();

            $status=array();
      
            array_push($status,[
                    "id"=>0,
                    "status"=>"Pending",
                    "date"=>"2023-07-10",
                    "message"=>"Test",
                ]);

            array_push($status,[
                "id"=>0,
                "status"=>"Payed Request",
                "date"=>"2023-07-10",
                "message"=>"Test",
            ]);


            array_push($status,[
                "id"=>0,
                "status"=>"Confirmed",
                "date"=>"2023-07-10",
                "message"=>"Test",
            ]);

            array_push($status,[
                "id"=>0,
                "status"=>"Shiped",
                "date"=>"2023-07-10",
                "message"=>"Test",
            ]);



            array_push($status,[
                "id"=>0,
                "status"=>"Approved",
                "date"=>"2023-07-10",
                "message"=>"Test",
            ]);


            array_push($status,[
                "id"=>0,
                "status"=>"Approved",
                "date"=>"2023-07-10",
                "message"=>"Test",
            ]);


            foreach ($order_status as $sta){
                array_push($status,[
                    "id"=>$sta->id,
                    "status"=>$sta->status,
                    "date"=>$sta->date,
                    "message"=>$sta->message,
                ]);

            }

            return Response::json(
                [
                    "error"=>false,
                    "delivery_type"=>$ship_info->shipping_type,
                    "delivery_date"=>$order_info->estimate_delivery_date,
                    "tracks"=>$status
                ]
            );


        }else{
            return Response::json(
                [
                    "error"=>true,
                    "msg"=>"No Order Found",
                ]
            );
        }



    }

    function AddTrackOrder($id,Request $request){
        OrderTracking::create([
            "order_id"=>$id,
            "status"=>$request->status,
            "date"=>date("Y-m-d"),
            "message"=>$request->message,
        ]);


        return Response::json([
            "error"=>false,
            " msg"=>"Successfully Added Status"
        ]);
    }
    function Update(Request $request){
        OrderTracking::where("id",$request->id)->update([
            "status"=>$request->status,
            "date"=>date("Y-m-d"),
            "message"=>$request->message,
        ]);


        return Response::json([
            "error"=>false,
            " msg"=>"Successfully Status Updated"
        ]);
    }
    function Delete($id,Request $request){
        OrderTracking::where("id",$id)->delete();


        return Response::json([
            "error"=>false,
            " msg"=>"Successfully Status Deleted"
        ]);
    }
    //Buyer Part

}
