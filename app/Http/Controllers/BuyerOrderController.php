<?php

namespace App\Http\Controllers;

use App\Models\BuyerPaymentMethod;
use App\Models\carts;
use App\Models\ExtraCharge;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrdersTree;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Seller;
use App\Models\SellerExtraCharges;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BuyerOrderController extends Controller
{

    function Index(Request $request){

        $order_list=OrdersTree::where("buyer_id",$request->user()->id)->get();

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
            $order_payment=false;
            $delivery_payment=false;

            foreach ($orders as $value){
                $total_price+=$value->total_amount;
                if($product_image==""){
                    $varient_id=$value->variant_id;
                    $product_varient=ProductVarient::where("id",$varient_id)->first();
                    $product_image=config("app.url")."storage/varients/".$product_varient->color;

                    $payment_id=$value->payment_method_id;
                   $buyer_payment_method=BuyerPaymentMethod::where("id",$value->payment_method_id)->first();
                   
                   if($buyer_payment_method!=null){
                    $payment_logo=config("app.url")."storage/payment/method/".$buyer_payment_method->logo;
                    $payment_name=$buyer_payment_method->name;
                    if($buyer_payment_method->is_bank==0){
                        $is_bank=false;
                    }else{
                        $is_bank=true;
                    }
                   }else{
                    $payment_logo=null;
                    $payment_name=null;
                    $is_bank=false;
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

            array_push($response_data,[
                "id"=>$order->id,
                "order_id"=>$order->customer_order_id,
                "order_date"=>$order->created_at,
                "total_item"=>count(json_decode($order->orders_id)),
                "total_amount"=>$order->payable_amount,
                "image"=>$product_image,
                "payment_method_id"=>$payment_id,
                "payment_method_name"=>$payment_name,
                "payment_method_logo"=>$payment_logo,
                "is_bank"=>$is_bank,
                "order_status"=>$ordr_status
            ]);


        }





        return Response::json([
            "error"=>false,
            "data"=>$response_data
        ]);

    }


    function Show($order_id,Request $request){

        $response_data=array();

        $product_data_response=array();

        $orders_data= OrdersTree::where(["customer_order_id"=>$order_id])->first();
        $order_id_list=json_decode($orders_data->orders_id);

        $orders=Order::whereIn("order_id",$order_id_list)->get();


        $total_amount=0;
        $total_shipping=0;
        $total_coupon=0;
        $total_voucher=0;
        $all_include_price=0;
        $shipping_per_kg=0;
        $unit_weight=0;

        $is_bank=false;
        $order_payment=false;
        $delivery_payment=false;

        $processing_fee=0;
        $total_extra_charge=0;
        foreach ($orders as $value){

            $seller_info=Seller::where("id",$value->seller_id)->first();
            $flag_url=DB::table("country")->where("name",$seller_info->country)->first()->flag;

            $buyer_payment_method=BuyerPaymentMethod::where("id",$value->payment_method_id)->first();
            $payment_logo=config("app.url")."storage/payment/method/".$buyer_payment_method->logo;

            if($buyer_payment_method->is_bank==0){
                $is_bank=false;
            }else{
                $is_bank=true;
            }


            $varient_id=$value->variant_id;
            $product_varient=ProductVarient::where("id",$varient_id)->first();
            $product_image=config("app.url")."storage/varients/".$product_varient->color;


            array_push($product_data_response,[
                "seller_id"=>$value->seller_id,
                "shop_name"=>$seller_info->shop_name,
                "shop_flag"=>config("app.url")."storage/flag/".$flag_url,
                "track_id"=>$value->order_id,
                "date"=>$value->created_at,
                "product_image"=>$product_image,
                "quantity"=>$value->quantity,
                "price"=>$value->product_price,
                "total"=>$value->amount,
                "varient_info"=>json_decode($value->varient_info),
                "payment_type_logo"=>$payment_logo
            ]);
            $processing_fee+=20;
            $total_amount+=$value->amount;
            $all_include_price+=$value->total_amount;
            $shipping_per_kg=$value->shipping_charge;
            $unit_weight+=($value->unit_weight);
            $total_shipping+=$value->customer_shipping_fee;

            if($total_coupon==0){
                if(count(json_decode($value->coupon_info))>0){
                    if(json_decode($value->coupon_info)[0]->discount_type=="FLAT"){
                        $total_coupon=json_decode($value->coupon_info)[0]->discount_value;
                    }else{
                        $total_coupon=json_decode($value->coupon_info)[0]->discount_value;
                    }

                }
            }

            if($total_voucher==0){
                if(count(json_decode($value->voucher_info))>0){
                    $total_voucher=json_decode($value->voucher_info)[0]->amount;
                }
            }


            $product_info=Product::where("id",$value->product_id)->first();

            $charges=SellerExtraCharges::where(["catagory_id"=>$product_info->catagory_id,"seller_id"=>$value->seller_id])->get();
            foreach ($charges as $charge){
                $amount=$charge->charge_amount;
                $total_extra_charge+=$amount;
            }



        }

        $payment_info_order=OrderPayment::where(["order_id"=>$orders_data->id,"payment_type"=>"order"])->get();
        $payment_info_delivery=OrderPayment::where(["order_id"=>$orders_data->id,"payment_type"=>"delivery"])->get();
        if(count($payment_info_order)>0){
            $order_payment=true;
        }
        if(count($payment_info_delivery)>0){
            $delivery_payment=true;
        }


        $ordr_status="PENDING";
        if($orders_data->status==0){
            $ordr_status="PAY-ORDER";
        }
        if($orders_data->status==2){
            $ordr_status="Confimed Order Payment";
        }
        if($orders_data->status==3){
            $ordr_status="PAY-SHIP";
        }
        if($orders_data->status==5){
            $ordr_status="Confimed Shipped Payment";
        }
        if($orders_data->status==6){
            $ordr_status="Sent Courier";
        }
        if($orders_data->status==7){
            $ordr_status="Delivered";
        }
        if($orders_data->status==404){
            $ordr_status="Rejected";
        }


        $response_data["products"]=$product_data_response;

        $amount_pay=($processing_fee+$total_extra_charge+$total_amount)-($total_coupon+$total_voucher);
        $response_data["payment"]=[
            "product_price"=>$total_amount,
            "processing_fee"=>$processing_fee,
            "extra_charges"=>$total_extra_charge,
            "total_coupon_disc"=>$total_coupon,
            "total_voucher_disc"=>$total_voucher,
            "payable_amount"=>$amount_pay,
        ];
        $response_data["shipping"]=[
            "shipping_per_kg"=>$shipping_per_kg,
            "unit_weight"=>$unit_weight,
            "total_shipping_total_charge"=>$total_shipping,
            "is_bank"=>$is_bank,
            "order_status"=>$ordr_status,
        ];


return Response::json([
    "error"=>false,
    "data"=>$response_data
]);

    }

    function ToDelivery($status,Request $request){

        $order_list=OrdersTree::where(["status"=>$status,"buyer_id"=>$request->user()->id])->get();

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
            $order_payment=false;
            $delivery_payment=false;

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
            }


//            0=Pending| 1=Payed Req | 2=COnfirm | 3=SHIP PAYMENT | 4=SHIP REQ | 5= SHIP ORDER CONFIRM || 404

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

            array_push($response_data,[
                "id"=>$order->id,
                "order_id"=>$order->customer_order_id,
                "order_date"=>$order->created_at,
                "total_item"=>count(json_decode($order->orders_id)),
                "total_amount"=>$order->payable_amount,
                "image"=>$product_image,
                "payment_method_id"=>$payment_id,
                "payment_method_name"=>$payment_name,
                "payment_method_logo"=>$payment_logo,
                "is_bank"=>$is_bank,
                "order_status"=>$ordr_status
            ]);


        }





        return Response::json([
            "error"=>false,
            "data"=>$response_data
        ]);
    }

    function Unpaid(Request $request){

        $orders=Order::where(["buyer_id"=>$request->user()->id,"delivery_payment_status"=>"unpaid","order_status_user"=>"Arrived"])->get();

        $data=array();
        foreach ($orders as $value){

            $products=json_decode($value->product_id);

            $products_info=array();
            for($a=0; $a<count($products); $a++){

                $p_info=Product::where(["id"=>$products])->first();

                $varient_id=json_decode($value->variant_id);

                $product_varient=ProductVarient::where("product_id",$varient_id[$a])->first();

                array_push($products_info,[
                    "id"=>$p_info->id,
                    "name"=>$p_info->product_name,
                    "quantity"=>json_decode($value->quantity)[$a],
                    "size"=>json_decode($value->varient_info)[$a]->size,
                    "price"=>json_decode($value->product_price)[$a],
                    "total_price"=>(int)json_decode($value->product_price)[$a]*(int)json_decode($value->quantity)[$a],
                    "image"=>config("app.url")."storage/varients/".$product_varient->color,

                ]);
            }



            $ship_info=json_decode($value->shipping_info);
            $shippingInfo=array();

            foreach ($ship_info as $valuex){

                array_push($shippingInfo,
                    [
                        "from_country"=>$valuex->from_country,
                        "to_country"=>$valuex->to_country,
                        "amount"=>$valuex->amount,
                        "days"=>$valuex->days,
                        "shipping_type"=>$valuex->shipping_type,

                    ]
                );
            }


            array_push($data,[
                "id"=>$value->id,
                "order_id"=>$value->order_id,
                "track_id"=>$value->track_id,
                "order_date"=>$value->date,
                "order_status"=>$value->order_status_user,
                "order_payment_status"=>$value->payment_status,
                "order_delivery_payment_status"=>$value->delivery_payment_status,
                "shipping_info"=>$shippingInfo,
                "shipping_charge"=>$value->shipping_charge,
                "delivery_charge"=>$value->delivery_charge,
                "amount"=>$value->amount,
                "disc_amount"=>$value->disc_amount,
                "total_amount"=>(int)$value->amount-(int)$value->disc_amount,
                "products"=>$products_info,
                "is_arrived"=>$value->order_status_user=="Arrived"?1:0

            ]);

        }

        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);
    }
    function PaymentInfoSubmit($id,Request $request){


        $order_list=OrdersTree::where("customer_order_id",$id)->first();


        $total_price=0;
        $trx_image="";

        $orders_id=json_decode($order_list->orders_id);
        $orders=Order::whereIn("order_id",$orders_id)->get();
        $payment_type="";

        foreach ($orders as $value){
            $total_price+=$value->total_amount;

            $payment_method=BuyerPaymentMethod::where("id",$value->payment_method_id)->first();
            $payment_type=$payment_method->name;
        }

        if($request->trx_img!=null){
            list($type, $imageData) = explode(';', $request->trx_img);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            $trx_image=$fileName;
            Storage::disk("public")->put("payments/trx_img/".$fileName,$imageData);
        }



        OrderPayment::create([
            "order_id"=>$order_list->id,
            "amount"=>$total_price-$order_list->discount_amount,
            "trx_id"=>$request->trx_id,
            "trx_img"=>$trx_image,
            "payment_type"=>"order",
            "payment_method"=>$payment_type
        ]);

        OrdersTree::where("customer_order_id",$id)->update([
            "product_payment"=>"Submited",
            "status"=>1

        ]);







        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Payment Info Stored"
        ]);

    }
    function DeliveryFeePay(Request $request){

        $get_info=OrdersTree::where(["customer_order_id"=>$request->order_id])->first();


        $orders_id=json_decode($get_info->orders_id);

        $order=Order::whereIn("order_id",$orders_id)->first();

             $payment=$request->payments;

                    if($payment["image"]!=null){
                        list($type, $imageData) = explode(';', $payment["image"]);
                        list(,$extension) = explode('/',$type);
                        list(,$imageData)      = explode(',', $imageData);
                        $fileName = uniqid().'.'.$extension;
                        $imageData = base64_decode($imageData);

                        Storage::disk("public")->put("payments/".$fileName,$imageData);
                        OrderPayment::create([
                            "order_id"=>$get_info->order_id,
                            "amount"=>$get_info->shipping_charge+$get_info->delivery_charge,
                            "trx_img"=>$fileName,
                            "payment_method"=>$payment["name"],
                            "payment_method"=>$payment["name"],
                            "payment_type"=>"Delivery Fee"
                        ]);

                    }else{
                        OrderPayment::create([
                            "order_id"=>$get_info->customer_order_id,
                            "amount"=>$order->shipping_charge+$order->delivery_charge,
                            "trx_id"=>$payment["trx_id"],
                            "payment_method"=>$payment["name"],
                            "payment_type"=>"Delivery Fee"
                        ]);
                    }


        OrdersTree::where("customer_order_id",$request->order_id)->update([
            "delivery_payment"=>"Submited",
            "status"=>4

        ]);

                    return Response::json([
                        "error"=>false,
                        "msg"=>"Successfully Saved"
                    ]);



//        Order::where(["id"=>$request->order_id])->update([
//            "delivery_payment_status"=>"Pending"
//        ]);

    }
}
