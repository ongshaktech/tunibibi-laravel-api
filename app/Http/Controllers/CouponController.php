<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CouponController extends Controller
{
    function AddPercentCoupon(Request $request){

        Coupon::create([
            "seller_id"=>$request->user()->id,
            "coupon_code"=>$request->code,
            "usage_per_customer"=>1,
            "discount_type"=>"PERCENT",
            "discount_value"=>$request->disc_percent,
            "min_qty"=>$request->min_quanty,
            "min_order_amount"=>$request->min_order_amount,
            "max_disc_amount"=>$request->max_disc_amount,
            "show_to_customer"=>$request->show_coustomer
        ]);


        return response()->json([
            "error"=>false,
            "msg"=>"Coupon Created Succssfully"
        ]);
    }

    function AddFlatCoupon(Request  $request){
        Coupon::create([
            "seller_id"=>$request->user()->id,
            "coupon_code"=>$request->code,
            "usage_per_customer"=>1,
            "discount_type"=>"FLAT",
            "discount_value"=>$request->disc_amount,
            "min_qty"=>$request->min_quanty,
            "min_order_amount"=>$request->min_order_amount,
            "show_to_customer"=>$request->show_coustomer
        ]);


        return response()->json([
            "error"=>false,
            "msg"=>"Coupon Created Succssfully"
        ]);
    }
function AddDeal(Request  $request){


    DB::table("super_deals")->insert(["product_id"=>$request->product_id,"wholesale_price_id"=>json_encode($request->wholesale),"from"=>$request->from,"to"=>$request->to]);

        return response()->json([
            "error"=>false,
            "msg"=>"Flash Deal Added"
        ]);
}
    function AllCoupon(Request $request){
        $data=Coupon::where(["seller_id"=>$request->user()->id])->get();
        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function GetBuyerCoupons($id,Request $request){
        $coupons=Coupon::where(["seller_id"=>$id,"show_to_customer"=>true])->orWhere("is_public",1)->get();

        return response()->json([
            "error"=>false,
            "data"=>$coupons
        ]);

    }

    function GetBuyerDiscountAmount(Request $request){

        $data=Coupon::where(["coupon_code"=>$request->coupon])->first();


        if($data!=null){

            $token_min_amount=(int)$data->min_order_amount;
            $token_min_qty=(int)$data->min_qty;
            $token_max_disc_amount=(int)$data->max_disc_amount;
            $token_discount_value=(int)$data->discount_value;

            $min_amount=$request->product_price;
            $min_qty=$request->quantity;

            if($min_amount>=$token_min_amount && $min_qty>=$token_min_qty){

                if($data->discount_type=="PERCENT"){
                   $max_amount_disc=($request->product_price/100)*$token_discount_value;
                   if($max_amount_disc>$token_max_disc_amount){
                       return Response::json([
                           "error"=>false,
                           "data"=>[
                               "id"=>$data->id,
                               "amount"=>$token_max_disc_amount
                           ]
                       ]);
                   }else{
                       return Response::json([
                           "error"=>false,
                           "data"=>[
                               "id"=>$data->id,
                               "amount"=>$max_amount_disc
                           ]
                       ]);
                   }

                }else{
                    return Response::json([
                        "error"=>false,
                        "data"=>[
                            "id"=>$data->id,
                            "amount"=>$data->discount_value
                        ]
                    ]);
                }

            }
            else{

                if($min_amount<=$token_min_amount){
                    return Response::json([
                        "error"=>true,
                        "msg"=>"Minimum Order Amount Should Be ".$token_min_amount
                    ]);
                }
                else if($min_qty<=$token_min_qty){
                    return Response::json([
                        "error"=>true,
                        "msg"=>"Minimum Order Quantity Should Be ".$token_min_qty
                    ]);
                }

            }

        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"No Token Found"
            ]);
        }

    }
}
