<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrdersTree;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\wirehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class WirehouseController extends Controller
{

    function login(Request $request){

        $wirehouse=wirehouse::where("number",$request->phone)->first();

        if($wirehouse!=null && Hash::check($request->password,$wirehouse->password)){

            $token=$wirehouse->createToken($wirehouse->id)->plainTextToken;

            return Response::json([
                "error"=>false,
                "msg"=>"Success",
                "token"=>$token,
                "data"=>$wirehouse
            ]);

        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Invalid Information"
            ]);
        }
    }

    function check_in(Request $request){

        $order=Order::where([
            "order_id"=>$request->order_id,
        ])->first();

        if($order!=null){
            $data_response=array();

            $seller_info=\App\Models\Seller::where("id",$order->seller_id)->first();

            $data_response["seller_info"]=[
                "shop_name"=>$seller_info->shop_name,
                "phone"=>$seller_info->phone,
                "email"=>$seller_info->email,
                "address"=>$seller_info->address,
                "logo"=>config("app.url")."logo/".$seller_info->logo,
            ];


            $pvalues=Product::where("id",$order->product_id)->first();


            $varient_id=$order->variant_id;
            $product_varient=ProductVarient::where("id",$varient_id)->first();
            $product_image=config("app.url")."storage/varients/".$product_varient->color;


            $data_response["product_info"]=[
                "id"=>$order->id,
                "product_id"=>$pvalues->id,
                "product_name"=>$pvalues->product_name,
                "image"=>$product_image,
                "varient_id"=>$order->variant_id,
                "varient_info"=>json_decode($order->varient_info),
                "quantity"=>$order->quantity,
                "seller_status"=>$order->order_status_seller,
                "wirehouse_status"=>$order->status_warehouse,
            ];

            $ship_info=json_decode($order->shipping_info);
            $data_response["shipping_info"]=[
                "Destination_Country"=>$ship_info[0]->to_country,
                "Shipping_Type"=>$ship_info[0]->shipping_type,
            ];
            return Response::json([
                "error"=>false,
                "data"=>$data_response
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Not Found"
            ]);
        }






    }




    function check_in_product($id,Request $request){
        $order=Order::where([
            "order_id"=>$id,
        ])->update([
            "status_warehouse"=>"Arrived Wirehouse"
        ]);

        OrderTracking::create([
            "order_id"=>$id,
            "status"=>"Arrived Wirehouse",
            "date"=>date("Y-m-d"),
            "message"=>$request->note,
        ]);


        return Response::json([
            "error"=>false,
            " msg"=>"Successfully Check In"
        ]);


    }


    function SendProductWordWide($id,Request $request){
        $order=Order::where([
            "order_id"=>$id,
        ])->update([
            "status_warehouse"=>"Shipped",
            "destination_wirehouse_id"=>$request->destination_wirehouse_id,
            "wirehouse_note"=>$request->note,
        ]);

        OrderTracking::create([
            "order_id"=>$id,
            "status"=>"Shipped",
            "date"=>date("Y-m-d"),
            "message"=>$request->note,
        ]);


        return Response::json([
            "error"=>false,
            " msg"=>"Successfully Check In"
        ]);
    }

    function ReceiveOrder($id,Request $request){
        $order=Order::where([
            "order_id"=>$id,
        ])->first();

        if($order!=null){
            $data_response=array();

            $seller_info=\App\Models\Seller::where("id",$order->seller_id)->first();

            $data_response["seller_info"]=[
                "shop_name"=>$seller_info->shop_name,
                "phone"=>$seller_info->phone,
                "email"=>$seller_info->email,
                "address"=>$seller_info->address,
                "logo"=>config("app.url")."logo/".$seller_info->logo,
            ];
            $buyer_shipping_addresses_info=json_decode($order->buyer_shipping_addresses_info)[0];
            $data_response["customer_address"]=[
            "full_name"=>$buyer_shipping_addresses_info->name1." ".$buyer_shipping_addresses_info->name2,
            "mobile"=>$buyer_shipping_addresses_info->mobile,
            "apartment"=>$buyer_shipping_addresses_info->apartment,
            "street"=>$buyer_shipping_addresses_info->street,
            "city"=>$buyer_shipping_addresses_info->city,
            "zip"=>$buyer_shipping_addresses_info->zip,
            "state"=>$buyer_shipping_addresses_info->state,
            "country"=>$buyer_shipping_addresses_info->country
            ];


            $pvalues=Product::where("id",$order->product_id)->first();


            $varient_id=$order->variant_id;
            $product_varient=ProductVarient::where("id",$varient_id)->first();
            $product_image=config("app.url")."storage/varients/".$product_varient->color;


            $data_response["product_info"]=[
                "id"=>$order->id,
                "product_id"=>$pvalues->id,
                "product_name"=>$pvalues->product_name,
                "image"=>$product_image,
                "varient_id"=>$order->variant_id,
                "varient_info"=>json_decode($order->varient_info),
                "quantity"=>$order->quantity,
                "wirehouse_status"=>$order->status_warehouse,
            ];

            $ship_info=json_decode($order->shipping_info);
            $data_response["shipping_info"]=[
                "From_Country"=>$ship_info[0]->from_country,
                "Destination_Country"=>$ship_info[0]->to_country,
                "Shipping_Type"=>$ship_info[0]->shipping_type,
            ];
            return Response::json([
                "error"=>false,
                "data"=>$data_response
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Not Found"
            ]);
        }
    }

    function ReceiveOrderProductConfirm($id,Request $request){

        $order=Order::where([
            "order_id"=>$id,
        ])->update([
            "status_warehouse"=>"Arrived Destination Country",
            "customer_shipping_fee"=>$request->customer_shipping_fee,
            "customer_delivery_fee"=>$request->customer_delivery_fee,
            "shipping_weight"=>$request->total_weight,
            "destination_wirehouse_note"=>$request->note,
        ]);

        OrderTracking::create([
            "order_id"=>$id,
            "status"=>"Arrived Destination Country",
            "date"=>date("Y-m-d"),
            "message"=>"",
        ]);

        $data=OrdersTree::whereJsonContains("orders_id",[$id])->first();

        $orders_id=json_decode($data->orders_id);

        $orders=Order::whereIn("order_id",$orders_id)->get();

        $total_weight_add=0;

        $payable_amount=0;
        foreach ($orders as $value){

            if($value->customer_shipping_fee>0 && $value->customer_delivery_fee>0){
                $total_weight_add++;
                $payable_amount+=$value->customer_shipping_fee+$value->customer_delivery_fee;
            }


        }

        if($total_weight_add==count($orders_id)){
        OrdersTree::where("id",$data->id)->update([
            "status"=>3,
            "payable_amount"=>$payable_amount
        ]);
        }
        return Response::json([
            "error"=>false,
            " msg"=>"Successfully Stored"
        ]);
    }


    function ReadyToCourier(){
        $order=OrdersTree::where("status",5)->get();

        $response_data=array();

        foreach ($order as $ordr){

            $orders_id=Order::whereIn("order_id",json_decode($ordr->orders_id))->get();
            // C56X3GBGHP2K
            // return Order::all();
        
            $products=array();
            $buyer_shipping_addresses_info=null;

            foreach ($orders_id as $value){

                $pvalues=Product::where("id",$value->product_id)->first();


                $varient_id=$value->variant_id;
                $product_varient=ProductVarient::where("id",$varient_id)->first();
                $product_image=config("app.url")."storage/varients/".$product_varient->color;


                array_push($products,[
                    "id"=>$value->id,
                    "track_id"=>$value->order_id,
                    "product_id"=>$pvalues->id,
                    "product_name"=>$pvalues->product_name,
                    "image"=>$product_image,
                    "varient_id"=>$value->variant_id,
                    "varient_info"=>json_decode($value->varient_info),
                    "quantity"=>$value->quantity,
                    "wirehouse_status"=>$value->status_warehouse,
                ]);
                $buyer_shipping=json_decode($value->buyer_shipping_addresses_info)[0];
                $buyer_shipping_addresses_info=[
                    "full_name"=>$buyer_shipping->name1." ".$buyer_shipping->name2,
                    "mobile"=>$buyer_shipping->mobile,
                    "apartment"=>$buyer_shipping->apartment,
                    "street"=>$buyer_shipping->street,
                    "city"=>$buyer_shipping->city,
                    "zip"=>$buyer_shipping->zip,
                    "state"=>$buyer_shipping->state,
                    "country"=>$buyer_shipping->country
                ];
            }

            array_push($response_data,[
                "id"=>$ordr->customer_order_id,
                "products"=>$products,
                "customer_info"=>$buyer_shipping_addresses_info,
            ]);

        }


        return Response::json([
            "error"=>false,
            "data"=>$response_data
        ]);

    }

    function SendedCourier($id){
        $order=Order::where([
            "order_id"=>$id,
        ])->update([
            "status_warehouse"=>"Sent Courier",
        ]);

        OrderTracking::create([
            "order_id"=>$id,
            "status"=>"Sent Courier",
            "date"=>date("Y-m-d"),
            "message"=>"",
        ]);

        OrdersTree::where("customer_order_id",$id)->update([
            "status"=>6
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Courier Handover"
        ]);
    }
    function DeliveryConfirm($id){

        $order=Order::where([
            "order_id"=>$id,
        ])->update([
            "status_warehouse"=>"Delivered",
        ]);

        OrderTracking::create([
            "order_id"=>$id,
            "status"=>"Delivered",
            "date"=>date("Y-m-d"),
            "message"=>"",
        ]);

        OrdersTree::where("customer_order_id",$id)->update([
            "status"=>7
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Courier Handover"
        ]);
    }
    function index(){
        $data=wirehouse::all();

        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);

    }

    function store(Request $request){

        wirehouse::create([
            "country"=>$request->country,
            "name"=>$request->name,
            "address"=>$request->address,
            "number"=>$request->number,
            "city"=>$request->city,
            "postcode"=>$request->postcode,
            "password"=>Hash::make($request->password)
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Created"
        ]);
    }

    function update($id,Request $request){
        wirehouse::where("id",$id)->update([
            "country"=>$request->country,
            "name"=>$request->name,
            "address"=>$request->address,
            "number"=>$request->number,
            "city"=>$request->city,
            "postcode"=>$request->postcode
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }
    function passupdate($id,Request $request){
        wirehouse::where("id",$id)->update([
            "password"=>Hash::make($request->password)
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }
    function delete($id,Request $request){
        wirehouse::where("id",$id)->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }


}
