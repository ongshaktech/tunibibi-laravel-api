<?php

namespace App\Http\Controllers;

use App\Http\CurrencyHelper;
use App\Models\buy_together;
use App\Models\buyer_shipping;
use App\Models\buyer_shipping_address;
use App\Models\carts;
use App\Models\city_delivery_charge;
use App\Models\Coupon;
use App\Models\customer_coupon;
use App\Models\ExtraCharge;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrdersTree;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\SellerExtraCharges;
use App\Models\ShippingPackages;
use App\Models\Voucher;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartsController extends Controller
{


    function Index(Request $request){

       $data= carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0])->get()->unique("seller_id");
       $shipping=array();
       $summery=array();
       $response_data=array();
       $product_weight=0;
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();

        $total_amount=0;
        $coupon_discount=0;
        $voucher_disc=0;
        $coupon_info=null;
        $processing_fee=0;
        if($check_shipping!=null){
            foreach ($data as $value){

                $seller_id=\App\Models\Seller::where("id",$value->seller_id)->first();
                $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;

                //Get Products
                $carted_products= carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0,"seller_id"=>$value->seller_id])->get();

                $products=array();

                foreach ($carted_products as $pvalues){
                    $Product_info=Product::where("id",$pvalues->product_id)->first();
                    $product_varinet=ProductVarient::where("id",$pvalues->variant_id)->first();



                    $wholesale_info=WholesalePrice::where("product_id",$pvalues->product_id)->get();
                    $product_price=0;

                    $data_of_wholesale=array();

                    foreach ($wholesale_info as $v){
                        array_push($data_of_wholesale,$v);
                        if((int)$v->min_quantity>=(int)$pvalues->quantity && (int)$pvalues->quantity<=(int)$v->max_quantity){
                            $product_price=$v->amount;
                        }else{
                            $product_price=$v->amount;
                        }
                    }

                    array_push($products,[
                        "cart_id"=>$pvalues->id,
                        "product_id"=>$Product_info->id,
                        "product_name"=>$Product_info->product_name,
                        "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                        "varient_id"=>$pvalues->variant_id,
                        "varient_info"=>json_decode($pvalues->variant_info),
                        "quantity"=>$pvalues->quantity,
                        "price"=>$product_price,
                        "total"=>$product_price*$pvalues->quantity,
                        "is_selected"=>$pvalues->is_selected==0?false:true,
                    ]);


                    $product_weight+=$Product_info->weight_unit;

                    if($pvalues->is_selected==1){
                        $total_amount+=$product_price*$pvalues->quantity;

                        $all_same_seller_carts=carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0,"seller_id"=>$seller_id->id])->get();

                        $is_carted_coupon=customer_coupon::where([
                            "buyer_id"=>$request->user()->id,
                            "seller_id"=>$seller_id->id,
                            "is_used"=>0
                        ])->first();




                        if($is_carted_coupon!=null && $coupon_discount==0){
                            $data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                            $coupon_info=$data;
                            $token_min_amount=(int)$data->min_order_amount;
                            $token_min_qty=(int)$data->min_qty;
                            $token_max_disc_amount=(int)$data->max_disc_amount;
                            $token_discount_value=(int)$data->discount_value;
                            $min_amount=$product_price*$pvalues->quantity;
                            $min_qty=$pvalues->quantity;

                            if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){

                                if($data->discount_type=="PERCENT"){
                                    $max_amount_disc=($data->product_price/100)*$token_discount_value;
                                    if($max_amount_disc>$token_max_disc_amount){
                                        if($coupon_discount==0){
                                            $coupon_discount=$token_max_disc_amount;

                                        }

                                    }else{
                                        if($coupon_discount==0){
                                            $coupon_discount=$max_amount_disc;

                                        }
                                    }
                                }else{
                                    if($coupon_discount==0) {
                                        $coupon_discount = $data->discount_value;

                                    }
                                }

                            }
                        }
                        $processing_fee+=20;
                    }
                }

                $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag,"products"=>$products];

                array_push($response_data,$shop_info);

            }

            $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

            array_push($shipping,[
                "amount"=>$shipping_Data->amount,
                "days"=>$shipping_Data->days,
                "shipping_type"=>$shipping_Data->shipping_type,
                "product_weight"=>(int)$product_weight
            ]);


            $selected_voucher=Voucher::where("is_selected",1)->first();

            if($selected_voucher!=null){
                $voucher_info=$selected_voucher;
                $voucher_disc=(int)$selected_voucher->amount;
            }

            $grand_total=$coupon_discount+$voucher_disc;


        array_push($summery,[
            "price"=>$total_amount,
            "processing_fee"=>$processing_fee,
            "coupon_disc"=>$coupon_discount,
            "voucher_disc"=>$voucher_disc,
             "total"=>($total_amount+$processing_fee)-$grand_total,
            ]);

            return Response::json([
                "error"=>false,
                "data"=>$response_data,
                "shipping"=>$shipping,
                "summery"=>$summery
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "data"=>[]
            ]);
        }


    }

    function Select($id,Request $request){

        carts::where("id",$id)->update(["is_selected"=>1]);

        $data= carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0])->get()->unique("seller_id");
        $shipping=array();
        $summery=array();
        $response_data=array();
        $product_weight=0;
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();
        $processing_fee=0;
        $total_amount=0;
        $coupon_discount=0;
        $voucher_disc=0;
        $coupon_info=null;
        if($check_shipping!=null){
            foreach ($data as $value){

                $seller_id=\App\Models\Seller::where("id",$value->seller_id)->first();
                $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;

                //Get Products
                $carted_products= carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0,"seller_id"=>$value->seller_id])->get();

                $products=array();

                foreach ($carted_products as $pvalues){
                    $Product_info=Product::where("id",$pvalues->product_id)->first();
                    $product_varinet=ProductVarient::where("id",$pvalues->variant_id)->first();

                    $wholesale_info=WholesalePrice::where("product_id",$pvalues->product_id)->get();
                    $product_price=0;

                    $data_of_wholesale=array();

                    foreach ($wholesale_info as $v){
                        array_push($data_of_wholesale,$v);
                        if((int)$v->min_quantity>=(int)$pvalues->quantity && (int)$pvalues->quantity<=(int)$v->max_quantity){
                            $product_price=$v->amount;
                        }
                    }

                    array_push($products,[
                        "cart_id"=>$pvalues->id,
                        "product_id"=>$Product_info->id,
                        "product_name"=>$Product_info->product_name,
                        "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                        "varient_id"=>$pvalues->variant_id,
                        "varient_info"=>json_decode($pvalues->variant_info),
                        "quantity"=>$pvalues->quantity,
                        "price"=>$product_price,
                        "total"=>$product_price*$pvalues->quantity,
                        "is_selected"=>$pvalues->is_selected==0?false:true,
                    ]);

                    $product_weight+=$Product_info->weight_unit;

                    if($pvalues->is_selected==1){
                        $total_amount+=$product_price*$pvalues->quantity;

                        $all_same_seller_carts=carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0,"seller_id"=>$seller_id->id])->get();

                        $is_carted_coupon=customer_coupon::where([
                            "buyer_id"=>$request->user()->id,
                            "seller_id"=>$seller_id->id,
                            "is_used"=>0
                        ])->first();




                        if($is_carted_coupon!=null && $coupon_discount==0){
                            $data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                            $coupon_info=$data;
                            $token_min_amount=(int)$data->min_order_amount;
                            $token_min_qty=(int)$data->min_qty;
                            $token_max_disc_amount=(int)$data->max_disc_amount;
                            $token_discount_value=(int)$data->discount_value;
                            $min_amount=$product_price*$pvalues->quantity;
                            $min_qty=$pvalues->quantity;

                            if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){

                                if($data->discount_type=="PERCENT"){
                                    $max_amount_disc=($data->product_price/100)*$token_discount_value;
                                    if($max_amount_disc>$token_max_disc_amount){
                                        if($coupon_discount==0){
                                            $coupon_discount=$token_max_disc_amount;

                                        }

                                    }else{
                                        if($coupon_discount==0){
                                            $coupon_discount=$max_amount_disc;

                                        }
                                    }
                                }else{
                                    if($coupon_discount==0) {
                                        $coupon_discount = $data->discount_value;

                                    }
                                }

                            }
                        }
                        $processing_fee+=20;
                    }
                }

                $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag,"products"=>$products];

                array_push($response_data,$shop_info);

            }

            $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

            array_push($shipping,[
                "amount"=>$shipping_Data->amount,
                "days"=>$shipping_Data->days,
                "shipping_type"=>$shipping_Data->shipping_type,
                "product_weight"=>(int)$product_weight
            ]);


            $selected_voucher=Voucher::where("is_selected",1)->first();

            if($selected_voucher!=null){
                $voucher_info=$selected_voucher;
                $voucher_disc=(int)$selected_voucher->amount;
            }

            $grand_total=$coupon_discount+$voucher_disc;


            array_push($summery,[
                "price"=>$total_amount,
                "processing_fee"=>$processing_fee,
                "coupon_disc"=>$coupon_discount,
                "voucher_disc"=>$voucher_disc,
                "total"=>($total_amount+$processing_fee)-$grand_total,
            ]);

            return Response::json([
                "error"=>false,
                "data"=>$response_data,
                "shipping"=>$shipping,
                "summery"=>$summery
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Please Select Shipping Address"
            ]);
        }
    }
    function Unselect($id,Request $request){

        carts::where("id",$id)->update(["is_selected"=>0]);

        $data= carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0])->get()->unique("seller_id");
        $shipping=array();
        $summery=array();
        $response_data=array();
        $product_weight=0;
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();
        $processing_fee=0;
        $total_amount=0;
        $coupon_discount=0;
        $voucher_disc=0;
        $coupon_info=null;
        if($check_shipping!=null){
            foreach ($data as $value){

                $seller_id=\App\Models\Seller::where("id",$value->seller_id)->first();
                $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;

                //Get Products
                $carted_products= carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0,"seller_id"=>$value->seller_id])->get();

                $products=array();

                foreach ($carted_products as $pvalues){
                    $Product_info=Product::where("id",$pvalues->product_id)->first();
                    $product_varinet=ProductVarient::where("id",$pvalues->variant_id)->first();

                    $wholesale_info=WholesalePrice::where("product_id",$pvalues->product_id)->get();
                    $product_price=0;

                    $data_of_wholesale=array();

                    foreach ($wholesale_info as $v){
                        array_push($data_of_wholesale,$v);
                        if((int)$v->min_quantity>=(int)$pvalues->quantity && (int)$pvalues->quantity<=(int)$v->max_quantity){
                            $product_price=$v->amount;
                        }
                    }

                    array_push($products,[
                        "cart_id"=>$pvalues->id,
                        "product_id"=>$Product_info->id,
                        "product_name"=>$Product_info->product_name,
                        "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                        "varient_id"=>$pvalues->variant_id,
                        "varient_info"=>json_decode($pvalues->variant_info),
                        "quantity"=>$pvalues->quantity,
                        "price"=>$product_price,
                        "total"=>$product_price*$pvalues->quantity,
                        "is_selected"=>$pvalues->is_selected==0?false:true,
                    ]);

                    $product_weight+=$Product_info->weight_unit;

                    if($pvalues->is_selected==1){
                        $total_amount+=$product_price*$pvalues->quantity;

                        $all_same_seller_carts=carts::where(["buyer_id"=>$request->user()->id,"is_checkout"=>0,"seller_id"=>$seller_id->id])->get();

                        $is_carted_coupon=customer_coupon::where([
                            "buyer_id"=>$request->user()->id,
                            "seller_id"=>$seller_id->id,
                            "is_used"=>0
                        ])->first();




                        if($is_carted_coupon!=null && $coupon_discount==0){
                            $data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                            $coupon_info=$data;
                            $token_min_amount=(int)$data->min_order_amount;
                            $token_min_qty=(int)$data->min_qty;
                            $token_max_disc_amount=(int)$data->max_disc_amount;
                            $token_discount_value=(int)$data->discount_value;
                            $min_amount=$product_price*$pvalues->quantity;
                            $min_qty=$pvalues->quantity;

                            if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){

                                if($data->discount_type=="PERCENT"){
                                    $max_amount_disc=($data->product_price/100)*$token_discount_value;
                                    if($max_amount_disc>$token_max_disc_amount){
                                        if($coupon_discount==0){
                                            $coupon_discount=$token_max_disc_amount;

                                        }

                                    }else{
                                        if($coupon_discount==0){
                                            $coupon_discount=$max_amount_disc;

                                        }
                                    }
                                }else{
                                    if($coupon_discount==0) {
                                        $coupon_discount = $data->discount_value;

                                    }
                                }

                            }
                        }
                        $processing_fee+=20;
                    }
                }

                $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag,"products"=>$products];

                array_push($response_data,$shop_info);

            }

            $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

            array_push($shipping,[
                "amount"=>$shipping_Data->amount,
                "days"=>$shipping_Data->days,
                "shipping_type"=>$shipping_Data->shipping_type,
                "product_weight"=>(int)$product_weight
            ]);


            $selected_voucher=Voucher::where("is_selected",1)->first();

            if($selected_voucher!=null){
                $voucher_info=$selected_voucher;
                $voucher_disc=(int)$selected_voucher->amount;
            }

            $grand_total=$coupon_discount+$voucher_disc;


            array_push($summery,[
                "price"=>$total_amount,
                "processing_fee"=>$processing_fee,
                "coupon_disc"=>$coupon_discount,
                "voucher_disc"=>$voucher_disc,
                "total"=>($total_amount+$processing_fee)-$grand_total,
            ]);

            return Response::json([
                "error"=>false,
                "data"=>$response_data,
                "shipping"=>$shipping,
                "summery"=>$summery
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Please Select Shipping Address"
            ]);
        }
    }
    function Cart(Request $request){
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();

        if($check_shipping!=null){
            $seller_id=Product::where("id",$request->product_id)->first()->seller_id;
            carts::create([
                "seller_id"=>$seller_id,
                "buyer_id"=>$request->user()->id,
                "product_id"=>$request->product_id,
                "quantity"=>$request->quantity,
                "variant_id"=>$request->variant_id,
                "variant_info"=>json_encode($request->variant_info),
                "is_selected"=>1
            ]);

            return Response::json([
                "error"=>false,
                "msg"=>"Successfully added On Cart"
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Please add shipping address"
            ]);
        }





    }

    function Increment($id){

        $carts_quantity=carts::where(["id"=>$id])->first()->quantity;
        $status=carts::where(["id"=>$id])->update(["quantity"=>$carts_quantity+1]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);

    }
    function Decrement($id){

        $carts_quantity=carts::where(["id"=>$id])->first()->quantity;
        $status=carts::where(["id"=>$id])->update(["quantity"=>$carts_quantity-1]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);

    }

    function DeleteItem($id){
        carts::where(["id"=>$id])->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }

    function Checkout(Request $request){

        $with_id=Str::upper(Str::random(6)).date("YmdHis").$request->user()->id;

        $check_shipping_address=buyer_shipping_address::where(["buyer_id"=>$request->user()->id,"is_default"=>1])->first();
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();

        $products=array();

        if($check_shipping_address==null){

            return Response::json([
                "error"=>true,
                "msg"=>"Please Add You Shipping Address"
            ]);
        }
        elseif ($check_shipping==null){
            return Response::json([
                "error"=>true,
                "msg"=>"Please Select Package Shipping Type"
            ]);
        }
        else{
            $carts_data=carts::where("is_selected",1)->get();

            $all_order_id=array();
            $payable_amount=0;
            $grand_total_disc=0;
            $coupon_discount=0;
            $voucher_disc=0;
            $coupon_info=null;
            $voucher_info=null;
            foreach ($carts_data as $ordersP){

                $product_info=Product::where("id",$ordersP->product_id)->first();
                $product_varinet=ProductVarient::where("id",$ordersP->variant_id)->first();
                $seller_id=\App\Models\Seller::where("id",$product_info->seller_id)->first();
                $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;
                $product_price=0;
                $wholesale_info=WholesalePrice::where("product_id",$ordersP->product_id)->get();

                foreach ($wholesale_info as $v){
                    if((int)$v->min_quantity>=(int)$ordersP->quantity && (int)$ordersP->quantity<=(int)$v->max_quantity){
                        $product_price=$v->amount;
                    }else{
                        $product_price=$v->amount;
                    }
                }




                $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag];








                $selected_voucher=Voucher::where("is_selected",1)->first();

                if($selected_voucher!=null){
                  if($voucher_disc==0){
                      $voucher_info=$selected_voucher;
                      $voucher_disc=(int)$selected_voucher->amount;
                  }
                }

                $is_carted_coupon=customer_coupon::where([
                    "buyer_id"=>$request->user()->id,
                    "seller_id"=>$seller_id->id,
                    "is_used"=>0
                ])->first();




                if($is_carted_coupon!=null){
                    $data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                    $coupon_info=$data;
                    $token_min_amount=(int)$data->min_order_amount;
                    $token_min_qty=(int)$data->min_qty;
                    $token_max_disc_amount=(int)$data->max_disc_amount;
                    $token_discount_value=(int)$data->discount_value;
                    $min_amount=$product_price*$ordersP->quantity;
                    $min_qty=$ordersP->quantity;
                    if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                        if($data->discount_type=="PERCENT"){
                            $max_amount_disc=($ordersP->product_price/100)*$token_discount_value;
                            if($max_amount_disc>$token_max_disc_amount){
                                if($coupon_discount==0){
                                    $coupon_discount=$token_max_disc_amount;
                                }

                            }else{
                                if($coupon_discount==0){
                                    $coupon_discount=$max_amount_disc;
                                }
                            }
                        }else{
                            if($coupon_discount==0) {
                                $coupon_discount = $data->discount_value;
                            }
                        }

                    }
                }




                $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();



                $track_id=Str::upper(Str::random(16));
                $order_id=Str::upper(Str::random(12));

                $total_extra_info=array();
                $total_extra_charge=0;
                $charges=SellerExtraCharges::where(["catagory_id"=>$product_info->catagory_id,"seller_id"=>$product_info->seller_id])->get();
                foreach ($charges as $charge){
                    $name=ExtraCharge::where("id",$charge->extra_charge_id)->first()->name;
                    $amount=$charge->charge_amount;
                    $total_extra_charge+=$amount;
                    array_push($total_extra_info,["name"=>$name,"amount"=>$amount]);
                }

                $grand_total=(int)$coupon_discount+(int)$voucher_disc;



                // return [
                //     "buyer_id"=>$request->user()->id,
                //     "seller_id"=>$seller_id->id,
                //     "order_id"=>$order_id,
                //     "product_id"=>$ordersP->product_id,
                //     "quantity"=>$ordersP->quantity,
                //     "wholesale_info"=>$wholesale_info,
                //     "varient_info"=>json_encode([json_decode($ordersP->variant_info)]),
                //     "variant_id"=>$product_varinet->id,
                //     "coupon_info"=>$coupon_discount==0?json_encode([]):json_encode([$coupon_info]),
                //     "product_price"=>$product_price,
                //     "amount"=>$product_price*$ordersP->quantity,
                //     "disc_amount"=>$grand_total,
                //     "shipping_info"=>json_encode([$shipping_Data]),
                //     "shipping_charge"=>$shipping_Data->amount,
                //     "buyer_shipping_addresses_info"=>json_encode([$check_shipping_address]),
                //     "charges"=>json_encode($total_extra_info),
                //     "orders_type"=>2,
                //     "track_id"=>$track_id,
                //     "dollar_rate"=>CurrencyHelper::GetCurrentDollarRate($request->user()->country),
                //     "payment_status"=>"Pending",
                //     "unit_weight"=>(int)$product_info->weight_unit,
                //     "unit_type"=>$product_info->weight_type,
                //     "voucher_info"=>$voucher_disc==0?json_encode([]):json_encode([$voucher_info]),
                //     "total_amount"=>($product_price*$ordersP->quantity+20+$total_extra_charge),
                //     "payment_method_id"=>$request->payement_method_id,
                //     "order_with"=>""
                // ];


      

                $order= Order::insert([
                    "buyer_id"=>$request->user()->id,
                    "seller_id"=>$seller_id->id,
                    "order_id"=>$order_id,
                    "product_id"=>$ordersP->product_id,
                    "quantity"=>$ordersP->quantity,
                    "wholesale_info"=>$wholesale_info,
                    "varient_info"=>json_encode([json_decode($ordersP->variant_info)]),
                    "variant_id"=>$product_varinet->id,
                    "coupon_info"=>$coupon_discount==0?json_encode([]):json_encode([$coupon_info]),
                    "product_price"=>$product_price,
                    "amount"=>$product_price*$ordersP->quantity,
                    "disc_amount"=>$grand_total,
                    "shipping_info"=>json_encode([$shipping_Data]),
                    "shipping_charge"=>$shipping_Data->amount,
                    "buyer_shipping_addresses_info"=>json_encode([$check_shipping_address]),
                    "charges"=>json_encode($total_extra_info),
                    "orders_type"=>2,
                    "track_id"=>$track_id,
                    "dollar_rate"=>CurrencyHelper::GetCurrentDollarRate($request->user()->country),
                    "payment_status"=>"Pending",
                    "unit_weight"=>(int)$product_info->weight_unit,
                    "unit_type"=>$product_info->weight_type??"KG",
                    "voucher_info"=>$voucher_disc==0?json_encode([]):json_encode([$voucher_info]),
                    "total_amount"=>($product_price*$ordersP->quantity+20+$total_extra_charge),
                    "payment_method_id"=>$request->payement_method_id,
                    "order_with"=>""
                ]);
                $payable_amount+=($product_price*$ordersP->quantity+20+$total_extra_charge);

                array_push($all_order_id,$order_id);
            }





            $customer_order_id=Str::upper(Str::random(6)).date("sYHmdi").$request->user()->id.Str::upper(Str::random(6));
            OrdersTree::create([
                "buyer_id"=>$request->user()->id,
                "orders_id"=>json_encode($all_order_id),
                "discount_amount"=>$coupon_discount+$voucher_disc,
                "customer_order_id"=>$customer_order_id,
                "payable_amount"=>$payable_amount-($coupon_discount+$voucher_disc),
            ]);


            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Order",
                "OrderID"=>$customer_order_id,
                "payable_amount"=>$payable_amount-($coupon_discount+$voucher_disc),
            ]);

        }


    }

}
