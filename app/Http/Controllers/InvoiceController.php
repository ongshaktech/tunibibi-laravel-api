<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrdersTree;
use App\Models\Product;
use App\Models\ShippingPackages;
use App\Models\TunibibiAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Response;

class InvoiceController extends Controller
{
    function Show($id){
       $data=OrdersTree::where("customer_order_id",$id)->first();

        if($data!=null){
            $orders_id=json_decode($data->orders_id);
            $orders=Order::whereIn("order_id",$orders_id)->get();
            $formated_data=array();

            $formated_data["invoice_number"]=$data->customer_order_id;
            $payment_status="Pending";
            if($data->status==0){
                $payment_status="PAY-ORDER";
            }
            if($data->status==0){
                $payment_status="PAY-SHIP";
            }

            $formated_data["payment_status"]=$payment_status;
            $formated_data["order_date"]=$data->created_at;
            $formated_data["due_date"]=$data->updated_at;
            $formated_data["bill_from_address"]=TunibibiAddress::first();
            $formated_data["bill_to_address"]=TunibibiAddress::first();
            $items=array();
            $items_ship=array();
            $items_ship_total=0;
            $extra_charges=null;
            $shipping=0;

            $total_p_price=0;
            $delivery_amount=0;
            $process_fee=0;
            foreach ($orders as $value){

                array_push($items,[
                    "name"=>Product::where("id",$value->product_id)->first()->product_name,
                    "quantity"=>$value->quantity,
                    "total"=>$value->amount,
                ]);


                array_push($items_ship,[
                    "unit_cost"=>$value->shipping_charge,
                    "weight"=>$value->unit_weight,
                    "total"=>$value->customer_shipping_fee,
                ]);
                $items_ship_total+=$value->customer_shipping_fee;
                $total_p_price+=$value->amount;
                $process_fee+=20;
                $extra_charges=json_decode($value->charges);

                $shipping+=$value->shipping_charge;

                $delivery_amount+=$value->customer_delivery_fee+$value->seller_delivery_charge;

            }
            $formated_data["order"]["products"]=$items;
            $formated_data["order"]["extra_charges"]=$extra_charges;
            $formated_data["order"]["total_product_price"]=$total_p_price;
            $formated_data["order"]["discount"]=$data->discount_amount;
            $formated_data["order"]["payable_amount"]=($total_p_price+$process_fee)-$data->discount_amount;
            $formated_data["shipping"]["products"]=$items;
            $formated_data["shipping"]["ship_charge"]=$items_ship;
            $formated_data["shipping"]["total_charge"]=$items_ship_total;
            $formated_data["shipping"]["delivery"]=$delivery_amount;
            $formated_data["shipping"]["payable_amount"]=$items_ship_total+$delivery_amount;

            return Response::json([
                "error"=>false,
                "data"=>$formated_data
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"NO Data Found"
            ]);
        }


    }

    function Orders(Request $request){
        $data=OrdersTree::where(["buyer_id"=>$request->user()->id,"status"=>0])->get();

        return Response::json([
            "error"=>false,
            "total_pending"=>count($data)
        ]);
    }

    function Notification(Request $request){

        $data=array();
        array_push($data,[
            "type"=>"promos",
            "time"=>Date::now(),
            "message"=>"TEST ABC"
        ]);

        array_push($data,[
            "type"=>"order",
            "time"=>Date::now(),
            "message"=>"TEST ABC"
        ]);

        array_push($data,[
            "type"=>"delivery",
            "time"=>Date::now(),
            "message"=>"TEST ABC"
        ]);

        array_push($data,[
            "type"=>"account",
            "time"=>Date::now(),
            "message"=>"TEST ABC"
        ]);

        return Response::json([
            "error"=>false,
            "total_pending"=>$data
        ]);
    }


}
