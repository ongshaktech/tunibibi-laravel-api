<?php

namespace App\Http\Controllers;

use App\Http\CurrencyHelper;
use App\Models\buy_now;
use App\Models\buyer_shipping;
use App\Models\buyer_shipping_address;
use App\Models\Coupon;
use App\Models\customer_coupon;
use App\Models\ExtraCharge;
use App\Models\Order;
use App\Models\OrdersTree;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\SellerExtraCharges;
use App\Models\ShippingPackages;
use App\Models\Voucher;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class BuyNowController extends Controller
{


    function store(Request $request){

        buy_now::where("buyer_id",$request->user()->id)->delete();

        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();

        $products=array();

        if($check_shipping!=null){
           $id=buy_now::insertGetId([
                "buyer_id"=>$request->user()->id,
                "product_id"=>$request->product_id,
                "shipping_id"=>$check_shipping->id,
                "varient_id"=>$request->varient_id,
                "quantity"=>$request->quantity,
               "varient_info"=>json_encode($request->varient_info)
        ]);



            $product_info=Product::where("id",$request->product_id)->first();
            $product_varinet=ProductVarient::where("id",$request->varient_id)->first();
            $seller_id=\App\Models\Seller::where("id",$product_info->seller_id)->first();
            $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;
            $product_price=0;
            $wholesale_info=WholesalePrice::where("product_id",$request->product_id)->get();


            foreach ($wholesale_info as $v){
                if((int)$v->min_quantity>=(int)$request->quantity && (int)$request->quantity<=(int)$v->max_quantity){
                    $product_price=$v->amount;
                }
            }

            $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag];


            $coupon_discount=0;
            $voucher_disc=0;
            $is_carted_coupon=customer_coupon::where([
                "buyer_id"=>$request->user()->id,
                "seller_id"=>$seller_id->id,
                "is_used"=>0
            ])->first();

            if($is_carted_coupon!=null){
                $data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                $token_min_amount=(int)$data->min_order_amount;
                $token_min_qty=(int)$data->min_qty;
                $token_max_disc_amount=(int)$data->max_disc_amount;
                $token_discount_value=(int)$data->discount_value;
                $min_amount=$product_price*$request->quantity;
                $min_qty=$request->quantity;
                if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                    if($data->discount_type=="PERCENT"){
                        $max_amount_disc=($request->product_price/100)*$token_discount_value;
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



            array_push($products,[
                "buy_now_id"=>$id,
                "product_id"=>$request->product_id,
                "product_name"=>$product_info->product_name,
                "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                "varient_id"=>$product_varinet->id,
                "varient_info"=>$request->varient_info,
                "quantity"=>$request->quantity,
                "price"=>$product_price,
                "total"=>$product_price*$request->quantity,
                "processing_fee"=>20,
                "coupon_disc"=>$coupon_discount,
                "voucher_disc"=>$voucher_disc
            ]);


            $shipping=array();

            $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

            array_push($shipping,[
                "amount"=>$shipping_Data->amount,
                "days"=>$shipping_Data->days,
                "shipping_type"=>$shipping_Data->shipping_type,
                "product_weight"=>(int)$product_info->weight_unit
            ]);

            return Response::json([
                "error"=>false,
                "msg"=>"Added Successfully",
                "shop"=>$shop_info,
                "product"=>$products,
                "shipping"=>$shipping

            ]);

        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Please Select Shipping Address"
            ]);
        }



    }

    function applayvoucher(Request $request){
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();

        $products=array();

        if($check_shipping!=null){
            $id=buy_now::where([
                "buyer_id"=>$request->user()->id
            ])->first();



            $product_info=Product::where("id",$id->product_id)->first();
            $product_varinet=ProductVarient::where("id",$id->varient_id)->first();
            $seller_id=\App\Models\Seller::where("id",$product_info->seller_id)->first();
            $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;
            $product_price=0;
            $wholesale_info=WholesalePrice::where("product_id",$id->product_id)->get();

            foreach ($wholesale_info as $v){
                if((int)$v->min_quantity>=(int)$id->quantity && (int)$id->quantity<=(int)$v->max_quantity){
                    $product_price=$v->amount;
                }
            }

            $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag];


            $coupon_discount=0;
            $voucher_disc=0;

            $data_voucher=Voucher::where(["voucher_code"=>$request->token,"user_id"=>$request->user()->id])->first();
            if($data_voucher!=null){
                $voucher_disc=$data_voucher->amount;
                buy_now::where("id",$id->id)->update(["voucher_id"=>$data_voucher->id]);
            }

            $is_carted_coupon=customer_coupon::where([
                "buyer_id"=>$request->user()->id,
                "seller_id"=>$seller_id->id,
                "is_used"=>0
            ])->first();


            if($is_carted_coupon!=null){
                $data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                $token_min_amount=(int)$data->min_order_amount;
                $token_min_qty=(int)$data->min_qty;
                $token_max_disc_amount=(int)$data->max_disc_amount;
                $token_discount_value=(int)$data->discount_value;
                $min_amount=$product_price*$id->quantity;
                $min_qty=$id->quantity;
                if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                    if($data->discount_type=="PERCENT"){
                        $max_amount_disc=($id->product_price/100)*$token_discount_value;
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



            array_push($products,[
                "buy_now_id"=>$id->id,
                "product_id"=>$id->product_id,
                "product_name"=>$product_info->product_name,
                "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                "varient_id"=>$product_varinet->id,
                "varient_info"=>json_decode($id->varient_info),
                "quantity"=>$id->quantity,
                "price"=>$product_price,
                "total"=>$product_price*$id->quantity,
                "processing_fee"=>20,
                "coupon_disc"=>$coupon_discount,
                "voucher_disc"=>$voucher_disc,
                "grand_total"=>($product_price*$id->quantity)+20-($coupon_discount)-($voucher_disc)
            ]);


            $shipping=array();

            $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

            array_push($shipping,[
                "amount"=>$shipping_Data->amount,
                "days"=>$shipping_Data->days,
                "shipping_type"=>$shipping_Data->shipping_type,
                "product_weight"=>(int)$product_info->weight_unit
            ]);

            return Response::json([
                "error"=>false,
                "msg"=>"Added Successfully",
                "shop"=>$shop_info,
                "product"=>$products,
                "shipping"=>$shipping

            ]);

        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Please Select Shipping Address"
            ]);
        }



    }
    function checkout(Request $request){
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
            $id=buy_now::where([
                "buyer_id"=>$request->user()->id
            ])->first();



            $product_info=Product::where("id",$id->product_id)->first();
            $product_varinet=ProductVarient::where("id",$id->varient_id)->first();
            $seller_id=\App\Models\Seller::where("id",$product_info->seller_id)->first();
            $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;
            $product_price=0;
            $wholesale_info=WholesalePrice::where("product_id",$id->product_id)->get();

            foreach ($wholesale_info as $v){
                if((int)$v->min_quantity>=(int)$id->quantity && (int)$id->quantity<=(int)$v->max_quantity){
                    $product_price=$v->amount;
                }
            }

            $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag];


            $coupon_discount=0;
            $voucher_disc=0;
            $coupon_info=null;
            $voucher_info=null;
            if($id->voucher_id!=null){
                $data_voucher=Voucher::where(["id"=>$id->voucher_id])->first();
                $voucher_info=$data_voucher;
                if($data_voucher!=null){
                    $voucher_disc=(int)$data_voucher->amount;
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
                $min_amount=$product_price*$id->quantity;
                $min_qty=$id->quantity;
                if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                    if($data->discount_type=="PERCENT"){
                        $max_amount_disc=($id->product_price/100)*$token_discount_value;
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
            $total_extra_charge=0;
            $total_extra_info=array();
            $charges=SellerExtraCharges::where(["catagory_id"=>$product_info->catagory_id,"seller_id"=>$product_info->seller_id])->get();
            foreach ($charges as $charge){
                $name=ExtraCharge::where("id",$charge->extra_charge_id)->first()->name;
                $amount=$charge->charge_amount;
                $total_extra_charge+=$amount;
                array_push($total_extra_info,["name"=>$name,"amount"=>$amount]);
            }

            $grand_total=$coupon_discount+$voucher_disc;



            $order= Order::insert([
                "buyer_id"=>$request->user()->id,
                "seller_id"=>$seller_id->id,
                "order_id"=>$order_id,
                "product_id"=>$id->product_id,
                "quantity"=>$id->quantity,
                "wholesale_info"=>json_encode($wholesale_info),
                "varient_info"=>json_encode([json_decode($id->varient_info)]),
                "variant_id"=>$product_varinet->id,
                "coupon_info"=>$coupon_discount==0?json_encode([]):json_encode([$coupon_info]),
                "product_price"=>$product_price,
                "amount"=>$product_price*$id->quantity,
                "disc_amount"=>0,
                "shipping_info"=>json_encode([$shipping_Data]),
                "shipping_charge"=>$shipping_Data->amount,
                "buyer_shipping_addresses_info"=>json_encode([$check_shipping_address]),
                "charges"=>json_encode($total_extra_info),
                "orders_type"=>1,
                "track_id"=>$track_id,
                "dollar_rate"=>CurrencyHelper::GetCurrentDollarRate($request->user()->country),
                "payment_status"=>"Pending",
                "unit_weight"=>(int)$product_info->weight_unit,
                "unit_type"=>$product_info->weight_type,
                "voucher_info"=>$voucher_disc==0?json_encode([]):json_encode([$voucher_info]),
                "total_amount"=>($product_price*$id->quantity+20+$total_extra_charge),
                "payment_method_id"=>$request->payement_method_id,
                "order_with"=>""
            ]);




            $all_order_id=array();

            array_push($all_order_id,$order_id);
            $customer_order_id=Str::upper(Str::random(6)).date("sYHmdi").$request->user()->id.Str::upper(Str::random(6));
            OrdersTree::create([
                "buyer_id"=>$request->user()->id,
                "orders_id"=>json_encode($all_order_id),
                "discount_amount"=>$grand_total,
                "customer_order_id"=>$customer_order_id,
                "payable_amount"=>($product_price*$id->quantity+20+$total_extra_charge)-$grand_total
            ]);


            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Order",
                "OrderID"=>$customer_order_id,
                "payable_amount"=>($product_price*$id->quantity+20+$total_extra_charge)-$grand_total,
            ]);

        }



    }
}
