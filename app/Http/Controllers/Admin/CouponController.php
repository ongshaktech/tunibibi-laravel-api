<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function FlatDiscountStore(Request  $request){
        Coupon::create([
            "seller_id"=>$request->seller_id,
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
    function GetFlatDiscount(Request  $request){
       $data=Coupon::where(["discount_type"=>"FLAT"])->get();


        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }
    function UpdateFlatDiscount($id,Request  $request){
        Coupon::where(["id"=>$id])->update([
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
            "msg"=>"Coupon Updated Successfully"
        ]);

    }
    function SellerFlatDiscount($id,Request  $request){
        $data=Coupon::where(["discount_type"=>"FLAT","seller_id"=>$id])->get();


        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }


    function PercentDiscountStore(Request $request){

        Coupon::create([
            "seller_id"=>$request->seller_id,
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

    function GetPercentDiscount(Request  $request){
        $data=Coupon::where(["discount_type"=>"PERCENT"])->get();


        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function UpdatePercentDiscount($id,Request $request){

        Coupon::where(["id"=>$id])->update([
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
            "msg"=>"Coupon Updated Succssfully"
        ]);
    }

    function SellerPercentDiscount($id,Request  $request){
        $data=Coupon::where(["discount_type"=>"PERCENT","seller_id"=>$id])->get();


        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function Delete($id,Request  $request){
        Coupon::where(["id"=>$id])->delete();


        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }

}
