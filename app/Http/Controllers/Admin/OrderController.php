<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyerPaymentMethod;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrdersTree;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\SellerPayments;
use App\Models\wirehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{

    function ShowDetails($id){
//        0=Pending| 1=Payed Req | 2=COnfirm | 3=SHIP PAYMENT | 4=SHIP REQ | 5= SHIP ORDER CONFIRM || 404 Reject || 6 Sent Courier || 7 Deliveryed
        $order_list=OrdersTree::where("customer_order_id",$id)->get();

        $response_data=array();

        foreach ($order_list as $order){
            $orders_id=json_decode($order->orders_id);

            $orders=Order::whereIn("order_id",$orders_id)->get();

            $total_price=0;
            $product_image="";
            $payment_id=0;
            $payment_logo="";
            $payment_name="";
            $is_bank=false;

            $products_info=array();
            foreach ($orders as $value){
                $total_price+=$value->total_amount;
                if($product_image==""){
                    $varient_id=$value->variant_id;
                    $product_varient=ProductVarient::where("id",$varient_id)->first();
                    $product_image=config("app.url")."storage/varients/".$product_varient->color;

                    $payment_id=$value->payment_method_id;
                    $buyer_payment_method=BuyerPaymentMethod::where("id",$value->payment_method_id)->first();
                    $payment_logo=config("app.url")."storage/payment/method/".$buyer_payment_method->logo;
                    $payment_name=$buyer_payment_method->name;
                    if($buyer_payment_method->is_bank==0){
                        $is_bank=false;
                    }else{
                        $is_bank=true;
                    }

                }

                $payment_info_order=OrderPayment::where(["order_id"=>$order->id,"payment_type"=>"order"])->get();
                $payment_info_delivery=OrderPayment::where(["order_id"=>$order->id,"payment_type"=>"delivery"])->get();
                if(count($payment_info_order)>0){
                    $order_payment=true;
                }
                if(count($payment_info_delivery)>0){
                    $delivery_payment=true;
                }




                $p_info=Product::where(["id"=>$value->product_id])->first();

                $varient_id=json_decode($value->variant_id);

                $product_varient=ProductVarient::where("product_id",$varient_id)->first();



                $from_wirehouse=wirehouse::where("id",$value->wirehouse_id)->first();
                $destination_wirehouse=wirehouse::where("id",$value->destination_wirehouse_id)->first();

                array_push($products_info,[
                    "id"=>$p_info->id,
                    "track_id"=>$value->order_id,
                    "name"=>$p_info->product_name,
                    "quantity"=>$value->quantity,
                    "size"=>json_decode($value->varient_info),
                    "price"=>$value->product_price,
                    "shipping_info"=>json_decode($value->shipping_info),
                    "shipping_charge"=>json_decode($value->shipping_charge),
                    "seller_delivery_charge"=>json_decode($value->seller_delivery_charge),
                    "voucher_info"=>json_decode($value->voucher_info),
                    "coupon_info"=>json_decode($value->coupon_info),
                    "buyer_shipping_addresses_info"=>json_decode($value->buyer_shipping_addresses_info),
                    "customer_shipping_fee"=>$value->customer_shipping_fee,
                    "customer_delivery_fee"=>$value->customer_delivery_fee,
                    "unit_weight"=>$value->unit_weight,
                    "dollar_rate"=>$value->dollar_rate,
                    "charges"=>json_decode($value->charges),
                    "total_amount"=>$value->total_amount,
                    "from_wirehouse"=>$from_wirehouse,
                    "wirehouse_note"=>$value->wirehouse_note,
                    "status_warehouse"=>$value->status_warehouse,
                    "destination_wirehouse"=>$destination_wirehouse,
                    "destination_wirehouse_note"=>$value->destination_wirehouse_note,
                    "shipping_weight"=>$value->shipping_weight,
                    "image"=>config("app.url")."storage/varients/".$product_varient->color,

                ]);


            }




//            0=Pending| 1=Payed Req | 2=COnfirm | 3=SHIP PAYMENT | 4=SHIP REQ | 5= SHIP ORDER CONFIRM || 404 Reject || 6 Sent Courier || 7 Deliveryed

            $ordr_status="PENDING";
            if($order->status==0){
                $ordr_status="PAY-ORDER";
            }
            if($order->status==2){
                $ordr_status="Confimed Order Payment";
            }
            if($order->status==3){
                $ordr_status="PAY-SHIP";
            }
            if($order->status==5){
                $ordr_status="Confimed Shipped Payment";
            }
            if($order->status==6){
                $ordr_status="Sent Courier";
            }
            if($order->status==7){
                $ordr_status="Delivered";
            }
            if($order->status==404){
                $ordr_status="Rejected";
            }

            $payments=OrderPayment::where("order_id",$order->customer_order_id)->get();

            array_push($response_data,[
                "id"=>$order->id,
                "order_id"=>$order->customer_order_id,
                "order_date"=>$order->created_at,
                "total_item"=>count(json_decode($order->orders_id)),
                "payments"=>$payments,
                "products"=>$products_info,
                "total_amount"=>$total_price,
                "discount_amount"=>$order->discount_amount,
                "payable_amount"=>$total_price-$order->discount_amount,
                "order_status"=>$ordr_status
            ]);


        }





        return Response::json([
            "error"=>false,
            "data"=>$response_data
        ]);

    }

    function PendingOrders(){
       $data= OrdersTree::where("status",0)->orwhere("status",1)->get();

       $formated_data=array();


       foreach ($data as $value){


           $product_image=array();
           $orders_id=json_decode($value->orders_id);

           $orders=Order::whereIn("order_id",$orders_id)->get();

           foreach ($orders as $values){
               $varient_id=$values->variant_id;
               $product_varient=ProductVarient::where("id",$varient_id)->first();
               $pimage=config("app.url")."storage/varients/".$product_varient->color;
               array_push($product_image,$pimage);

           }



           $payment=OrderPayment::where([
               ["order_id","=",$value->customer_order_id],
               ["payment_type","=","order"],
           ])->first();



           array_push($formated_data,[
               "id"=>$value->id,
               "customer_order_id"=>$value->customer_order_id,
               "total_item"=>count($orders_id),
               "amount"=>$value->payable_amount,
               "product_images"=>$product_image,
               "payment"=>$payment,
               "payment_status"=>$payment==null?"Not Submited":"Pending",
               "date"=>$value->created_at
           ]);

       }


       return Response::json([
           "error"=>false,
           "data"=>$formated_data,
       ]);

    }

    function VerifyOrderPayment($id){

        OrderPayment::where("id",$id)->update([
            "is_verified"=>1
        ]);

        $data=OrderPayment::where("id",$id)->first();


        OrdersTree::where("customer_order_id",$data->order_id)->update([
            "status"=>2
        ]);



        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Confirmed"
        ]);





    }


    function DeliveryPendingOrders(){
        $data= OrdersTree::where("status",3)->orwhere("status",4)->get();

        $formated_data=array();


        foreach ($data as $value){


            $product_image=array();
            $orders_id=json_decode($value->orders_id);

            $orders=Order::whereIn("order_id",$orders_id)->get();

            foreach ($orders as $values){
                $varient_id=$values->variant_id;
                $product_varient=ProductVarient::where("id",$varient_id)->first();
                $pimage=config("app.url")."storage/varients/".$product_varient->color;
                array_push($product_image,$pimage);

            }



            $payment=OrderPayment::where([
                ["order_id","=",$value->customer_order_id],
                ["payment_type","=","Delivery Fee"],
            ])->first();



            array_push($formated_data,[
                "id"=>$value->id,
                "customer_order_id"=>$value->customer_order_id,
                "total_item"=>count($orders_id),
                "amount"=>$value->payable_amount,
                "product_images"=>$product_image,
                "payment"=>$payment,
                "payment_status"=>$payment==null?"Not Submited":"Pending",
                "date"=>$value->created_at
            ]);

        }


        return Response::json([
            "error"=>false,
            "data"=>$formated_data,
        ]);

    }

    function DeliveryVerifyOrderPayment($id){

        OrderPayment::where("id",$id)->update([
            "is_verified"=>1
        ]);

        $data=OrderPayment::where("id",$id)->first();

        OrdersTree::where("customer_order_id",$data->order_id)->update([
            "status"=>5
        ]);



        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Confirmed"
        ]);





    }

    function AllOrders(Request $request){
        $data= OrdersTree::where(function ($query) use ($request){

            if($request->order_id!=null){
                $query->orwhere("customer_order_id",$request->order_id);
            }

            if($request->status==null){
                $query->orwhere("id","!=",0);
            }else{
                $query->orwhere("status",$request->status);
            }
            if($request->from_date!=null && $request->to_date!=null){
                $query->orwhereBetween("created_at",[$request->from_date,$request->to_date]);
            }

        })->get();

        $formated_data=array();


        foreach ($data as $value){


            $product_image=array();
            $orders_id=json_decode($value->orders_id);

            $orders=Order::whereIn("order_id",$orders_id)->get();

            foreach ($orders as $values){
                $varient_id=$values->variant_id;
                $product_varient=ProductVarient::where("id",$varient_id)->first();
                $pimage=config("app.url")."storage/varients/".$product_varient->color;
                array_push($product_image,$pimage);

            }



            $payment=OrderPayment::where([
                ["order_id","=",$value->customer_order_id],
                ["payment_type","=","Delivery Fee"],
            ])->first();
            $ordr_status="PENDING";
            if($value->status==0){
                $ordr_status="PAY-ORDER";
            }
            if($value->status==2){
                $ordr_status="Confimed Order Payment";
            }
            if($value->status==3){
                $ordr_status="PAY-SHIP";
            }
            if($value->status==5){
                $ordr_status="Confimed Shipped Payment";
            }
            if($value->status==6){
                $ordr_status="Sent Courier";
            }
            if($value->status==7){
                $ordr_status="Delivered";
            }
            if($value->status==404){
                $ordr_status="Rejected";
            }


            array_push($formated_data,[
                "id"=>$value->id,
                "customer_order_id"=>$value->customer_order_id,
                "total_item"=>count($orders_id),
                "amount"=>$value->payable_amount,
                "product_images"=>$product_image,
                "payment"=>$payment,
                "payment_status"=>$payment==null?"Not Submited":"Pending",
                "order_status"=>$ordr_status,
                "date"=>$value->created_at
            ]);

        }


        return Response::json([
            "error"=>false,
            "data"=>$formated_data
        ]);
    }
}
