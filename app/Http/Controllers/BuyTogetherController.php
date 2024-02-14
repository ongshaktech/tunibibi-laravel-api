<?php

namespace App\Http\Controllers;

use App\Http\CurrencyHelper;
use App\Models\buy_now;
use App\Models\buy_together;
use App\Models\Buyer;
use App\Models\buyer_shipping;
use App\Models\buyer_shipping_address;
use App\Models\city_delivery_charge;
use App\Models\Coupon;
use App\Models\customer_coupon;
use App\Models\ExtraCharge;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrdersTree;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\SellerExtraCharges;
use App\Models\ShippingPackages;
use App\Models\Voucher;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BuyTogetherController extends Controller
{

    function Index(Request $request){
        $current_date=date("Y-m-d h:m:s");
        $get_buy_together_list=buy_together::where([["buyer_id","=",$request->user()->id],["expire_time",">=",$current_date],["is_complete","=",0]])->get()->unique("product_id");


        $all_data=array();
        foreach ($get_buy_together_list as $value){
            $wholesale_info=WholesalePrice::where("id",$value->wholesale_id)->first();
            $min_quantity=(int)$wholesale_info->min_quantity;
            $amount=$wholesale_info->amount;
            $total_quantity=$value->quantity;


            $peoples=buy_together::where([["expire_time","<",$current_date],["country","=",$request->user()->country],["product_id","=",$value->product_id]])->get();

            $people_list=array();
            foreach ($peoples as $data){
                $get_user_Profile=Buyer::where("id",$data->buyer_id)->first()->image;
                $people_image=config("app.url")."storage/buyers/".$get_user_Profile;
                $people_quantity=$data->quantity;
                $total_quantity+=$data->quantity;

                array_push($people_list,["profile_img"=>$people_image,"quantity"=>$people_quantity]);
            }


            $need=$min_quantity-$total_quantity;

            if($need<0){
                $need=0;
            }

            $products=Product::where("id",$wholesale_info->product_id)->get();
            $p_info=[];
            for($a=0; $a<count($products); $a++){
                $p_info["shop_id"]=(int)$products[$a]->seller_id;
                $p_info["product_name"]=$products[$a]->product_name;
                $images=ProductVarient::where("id",$value->product_varient_id)->first();
                $p_info["image"]=config("app.url")."storage/varients/".$images->color;

            }


            array_push($all_data,[
                "id"=>$value->id,
                "product_info"=>$p_info,
                "need"=>$need,
                "minimum_order"=>$min_quantity,
                "total_order"=>$total_quantity,
                "product_id"=>$value->product_id,
                "wholesale_id"=>$value->wholesale_id,
                "price"=>$amount,
                "share_link"=>base64_encode($value->product_id),
                "expire_time"=>$value->expire_time,
                "product_varient_id"=>$value->product_varient_id,
                "size"=>json_decode($value->size),
                "buyers"=>$people_list]);
        }




        return Response::json([
            "error"=>false,
            "data"=>$all_data
        ]);
    }


    function applayvoucher(Request $request){

        $data=buy_together::where(["id"=>$request->buy_together_id,"is_complete"=>0])->first();


        $new_format=array();
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();

        $products=array();

        if($data!=null){

            $product_info=Product::where("id",$data->product_id)->first();
            $product_varinet=ProductVarient::where("id",$data->product_varient_id)->first();
            $seller_id=\App\Models\Seller::where("id",$product_info->seller_id)->first();
            $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;
            $product_price=0;
            $wholesale_info=WholesalePrice::where("product_id",$data->product_id)->get();


            foreach ($wholesale_info as $v){
                if((int)$v->min_quantity>=(int)$data->quantity && (int)$data->quantity<=(int)$v->max_quantity){
                    $product_price=$v->amount;
                }
            }

            $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag];


            $coupon_discount=0;
            $voucher_disc=0;
               $voucher_info=null;
               if($request->token!=null){
                   $data_voucher=Voucher::where(["voucher_code"=>$request->token,"user_id"=>$request->user()->id])->first();
                   $voucher_info=$data_voucher;
                   if($data_voucher!=null){
                       buy_together::where(["id"=>$request->buy_together_id,"is_complete"=>0])->update(["voucher_id"=>$data_voucher->id]);
                       $voucher_disc=(int)$data_voucher->amount;
                   }
               }

            $is_carted_coupon=customer_coupon::where([
                "buyer_id"=>$request->user()->id,
                "seller_id"=>$seller_id->id,
                "is_used"=>0
            ])->first();

            if($is_carted_coupon!=null){
                $coupon_data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                $token_min_amount=(int)$coupon_data->min_order_amount;
                $token_min_qty=(int)$coupon_data->min_qty;
                $token_max_disc_amount=(int)$coupon_data->max_disc_amount;
                $token_discount_value=(int)$coupon_data->discount_value;
                $min_amount=$product_price*$data->quantity;
                $min_qty=$data->quantity;
                if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                    if($coupon_data->discount_type=="PERCENT"){
                        $max_amount_disc=($product_price/100)*$token_discount_value;
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
                            $coupon_discount = $coupon_data->discount_value;
                        }
                    }

                }
            }

            $grand_total=$coupon_discount+$voucher_disc;

            array_push($products,[
                "buy_together_id"=>$data->id,
                "product_id"=>$data->product_id,
                "product_name"=>$product_info->product_name,
                "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                "varient_id"=>$product_varinet->id,
                "varient_info"=>json_decode($data->size),
                "quantity"=>$data->quantity,
                "price"=>$product_price,
                "total"=>$product_price*$data->quantity,
                "processing_fee"=>20,
                "coupon_disc"=>$coupon_discount,
                "voucher_disc"=>$voucher_disc,
                "payable_amount"=>($product_price*$data->quantity+20)-$grand_total,
            ]);


            $shipping=array();

            $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

            array_push($shipping,[
                "amount"=>$shipping_Data->amount,
                "days"=>$shipping_Data->days,
                "shipping_type"=>$shipping_Data->shipping_type,
                "product_weight"=>(int)$product_info->weight_unit
            ]);

        }

        return Response::json([
            "error"=>false,
            "shop"=>$shop_info,
            "product"=>$products,
            "shipping"=>$shipping
        ]);


    }

    function Create(Request $request){

        $exp_date=date("Y-m-d h:m:s",strtotime("+ 24 hours"));


        $wholesale_info=WholesalePrice::where("product_id",$request->product_id)->get();

        $product_price=0;
        $wholesale_id=null;
        foreach ($wholesale_info as $v){
            if((int)$v->min_quantity>=(int)$request->quantity && (int)$request->quantity<=(int)$v->max_quantity){
                $product_price=$v->amount;
                $wholesale_id=$v->id;
            }
        }


        $status=buy_together::create([
            "product_id"=>$request->product_id,
            "quantity"=>$request->quantity,
            "wholesale_id"=>$wholesale_id,
            "invite_link"=>"ABC",
            "expire_time"=>$exp_date,
            "country"=>$request->user()->country,
            "buyer_id"=>$request->user()->id,
            "product_varient_id"=>$request->varient_id,
            "size"=>json_encode($request->varient_info),

        ]);

        if($status!=null){
            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Stored"
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Opps! There was something Wrong"
            ]);
        }
    }

    function Show(Request $request){
      $data=buy_together::where(["id"=>$request->id,"is_complete"=>0])->first();


      $new_format=array();
        $check_shipping=buyer_shipping::where("buyer_id",$request->user()->id)->first();



        $products=array();


        if($check_shipping!=null){
            if($data!=null){

                $product_info=Product::where("id",$data->product_id)->first();
                $product_varinet=ProductVarient::where("id",$data->product_varient_id)->first();
                $seller_id=\App\Models\Seller::where("id",$product_info->seller_id)->first();
                $get_flag=DB::table("country")->where(["name"=>$seller_id->country])->first()->flag;
                $product_price=0;
                $wholesale_info=WholesalePrice::where("product_id",$data->product_id)->get();


                foreach ($wholesale_info as $v){
                    if((int)$v->min_quantity>=(int)$data->quantity && (int)$data->quantity<=(int)$v->max_quantity){
                        $product_price=$v->amount;
                    }
                }

                $shop_info=["shop_id"=>$seller_id->id,"shop_name"=>$seller_id->shop_name,"country"=>config("app.url")."storage/flags/".$get_flag];


                $coupon_discount=0;
                $voucher_disc=0;
                if($data->voucher_id!=null){
                    $data_voucher=Voucher::where(["id"=>$data->voucher_id])->first();
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
                    $coupon_data=Coupon::where("id",$is_carted_coupon->coupon_id)->first();
                    $token_min_amount=(int)$coupon_data->min_order_amount;
                    $token_min_qty=(int)$coupon_data->min_qty;
                    $token_max_disc_amount=(int)$coupon_data->max_disc_amount;
                    $token_discount_value=(int)$coupon_data->discount_value;
                    $min_amount=$product_price*$data->quantity;
                    $min_qty=$data->quantity;
                    if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                        if($coupon_data->discount_type=="PERCENT"){
                            $max_amount_disc=($product_price/100)*$token_discount_value;
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
                                $coupon_discount = $coupon_data->discount_value;
                            }
                        }

                    }
                }

                $grand_total=$coupon_discount+$voucher_disc;

                array_push($products,[
                    "buy_together_id"=>$data->id,
                    "product_id"=>$data->product_id,
                    "product_name"=>$product_info->product_name,
                    "image"=>config("app.url")."storage/varients/".$product_varinet->color,
                    "varient_id"=>$product_varinet->id,
                    "varient_info"=>json_decode($data->size),
                    "quantity"=>$data->quantity,
                    "price"=>$product_price,
                    "total"=>$product_price*$data->quantity,
                    "processing_fee"=>20,
                    "coupon_disc"=>$coupon_discount,
                    "voucher_disc"=>$voucher_disc,
                    "payable_amount"=>($product_price*$data->quantity+20)-$grand_total,
                ]);


                $shipping=array();

                $shipping_Data=ShippingPackages::where("id",$check_shipping->shipping_package_id)->first();

                array_push($shipping,[
                    "amount"=>$shipping_Data->amount,
                    "days"=>$shipping_Data->days,
                    "shipping_type"=>$shipping_Data->shipping_type,
                    "product_weight"=>(int)$product_info->weight_unit
                ]);

            }
            return Response::json([
                "error"=>false,
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

    function QuantityUpdate($id){
        $getquantity=buy_together::where("id",$id)->first()->quantity;


        buy_together::where("id",$id)->update(["quantity"=>$getquantity+1]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }
    function QuantityDecress($id){
        $getquantity=buy_together::where("id",$id)->first()->quantity;
        buy_together::where("id",$id)->update(["quantity"=>$getquantity-1]);
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function Checkout(Request $request){

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
            $id=buy_together::where([
                "id"=>$request->buy_together_id
            ])->first();




            $product_info=Product::where("id",$id->product_id)->first();
            $product_varinet=ProductVarient::where("id",$id->product_varient_id)->first();
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
                "varient_info"=>json_encode([json_decode($id->size)]),
                "variant_id"=>$product_varinet->id,
                "coupon_info"=>$coupon_discount==0?json_encode([]):json_encode([$coupon_info]),
                "product_price"=>$product_price,
                "amount"=>$product_price*$id->quantity,
                "disc_amount"=>0,
                "shipping_info"=>json_encode([$shipping_Data]),
                "shipping_charge"=>$shipping_Data->amount,
                "buyer_shipping_addresses_info"=>json_encode([$check_shipping_address]),
                "charges"=>json_encode($total_extra_info),
                "orders_type"=>2,
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
                "payable_amount"=>($product_price*$id->quantity+20+$total_extra_charge)-$grand_total
            ]);

        }



    }
    function BuyNow(Request $request){

        $products=$request->product;

        $product_info=Product::where("id",$products["product_id"])->first();

        $seller_id=(int)$product_info->seller_id;

        $product_id=$products["product_id"];
        $quantity=$products["quantity"];
        $wholesale_info=WholesalePrice::where("id",$products["wholesale_id"])->first();

        $varient_info=$products["size"];
        $varient_id=$products["varient_id"];
        $product_price=$wholesale_info->amount;
        $total_amount=$quantity*$product_price;


        $shipping_info= ShippingPackages::where("id",$request->shipping_id)->first();
        $charge_shipping=json_decode($shipping_info->unit_types);
        $unit_type=$product_info->weight_type;
//        [{"KG": 100, "id": 1}]

        $shipping_charge=$charge_shipping[0]->$unit_type;
        $shipping_info=[
        "id" =>$shipping_info->id,
        "days" =>$shipping_info->days,
        "amount"=>$shipping_charge,
        "to_country"=>$shipping_info->to_country,
        "unit_types"=>json_decode($shipping_info->unit_types),
        "from_country" =>$shipping_info->from_country,
        "shipping_type" =>$shipping_info->shipping_type,
        ];






        $delivery_address=buyer_shipping_address::where("id",$request->delivery_address_id)->first();
        $delivery_charge=city_delivery_charge::where(["city_name"=>$delivery_address->city,"country_name"=>$delivery_address->country])->first()->amount;


        $total_extra_charge=0;
        $total_extra_info=array();
        $unit_weight=(int)$product_info->weight_unit;
        $unit_type=$product_info->weight_type;
        $charges=SellerExtraCharges::where(["catagory_id"=>$product_info->catagory_id,"seller_id"=>$product_info->seller_id])->get();

        foreach ($charges as $charge){
            $name=ExtraCharge::where("id",$charge->extra_charge_id)->first()->name;
            $amount=$charge->charge_amount;
            $total_extra_charge+=$amount;
            array_push($total_extra_info,["name"=>$name,"amount"=>$amount]);
        }


        $coupon=null;
        $disc_amount=0;
        $voucher=null;
        if($request->coupon_id!=null){
            $data=Coupon::where(["id"=>$request->coupon_id])->first();
            $coupon=$data;
            $token_min_amount=(int)$data->min_order_amount;
            $token_min_qty=(int)$data->min_qty;
            $token_max_disc_amount=(int)$data->max_disc_amount;
            $token_discount_value=(int)$data->discount_value;
            $min_amount=$total_amount;
            $min_qty=$quantity;
            if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){
                if($data->discount_type=="PERCENT"){
                    $max_amount_disc=($request->product_price/100)*$token_discount_value;
                    if($max_amount_disc>$token_max_disc_amount){
                        $disc_amount=$token_max_disc_amount;
                    }else{
                        $disc_amount=$max_amount_disc;
                    }
                }else{
                    $disc_amount=$data->discount_value;
                }

            }

        }



        if($request->voucher_id!=null){
            $data=Voucher::where(["id"=>$request->voucher_id])->first();
            $voucher=$data;
            $disc_amount+=$data->amount;

        }








        $track_id=Str::upper(Str::random(16));
        $order_id=Str::upper(Str::random(12));


        $order= Order::insert([
            "buyer_id"=>$request->user()->id,
            "seller_id"=>$seller_id,
            "order_id"=>$order_id,
            "product_id"=>$product_id,
            "quantity"=>$quantity,
            "wholesale_info"=>json_encode([$wholesale_info]),
            "varient_info"=>json_encode([$varient_info]),
            "variant_id"=>$varient_id,
            "coupon_info"=>$coupon==null?json_encode([]):json_encode([$coupon]),
            "product_price"=>$product_price,
            "amount"=>$total_amount,
            "disc_amount"=>$disc_amount,
            "shipping_info"=>json_encode([$shipping_info]),
            "shipping_charge"=>$shipping_charge,
            "buyer_shipping_addresses_info"=>json_encode([$delivery_address]),
            "charges"=>json_encode($total_extra_info),
            "orders_type"=>2,
            "track_id"=>$track_id,
            "dollar_rate"=>CurrencyHelper::GetCurrentDollarRate($request->user()->country),
            "payment_status"=>"Pending",
            "unit_weight"=>$unit_weight,
            "unit_type"=>$product_info->weight_type,
            "voucher_info"=>$voucher==null?json_encode([]):json_encode([$voucher]),
            "total_amount"=>($total_amount+$shipping_charge+$total_extra_charge),
            "payment_method_id"=>$request->payemnt_method_id
        ]);


        if($order){
            $customer_order_id=Str::upper(Str::random(6)).date("sYHmdi").$request->user()->id.Str::upper(Str::random(6));
            OrdersTree::create([
                "buyer_id"=>$request->user()->id,
                "orders_id"=>json_encode([$order_id]),
                "discount_amount"=>$disc_amount,
                "customer_order_id"=>$customer_order_id
            ]);
        }

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Order",
            "order_id"=>$order_id,
            "payable_amount"=>($total_amount+$shipping_charge+$total_extra_charge)-$disc_amount
        ]);

    }
}
