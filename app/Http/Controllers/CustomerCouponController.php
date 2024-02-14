<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\customer_coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CustomerCouponController extends Controller
{

    function store($id,Request $request){

        $coupon=Coupon::where("id",$id)->first();

        if($coupon!=null){

            $check_already_added=customer_coupon::where([
                "buyer_id"=>$request->user()->id,
                "seller_id"=>$coupon->seller_id,
                "coupon_id"=>$id
            ])->first();
            if($check_already_added==null){
        $store=customer_coupon::create([
            "buyer_id"=>$request->user()->id,
            "seller_id"=>$coupon->seller_id,
            "coupon_id"=>$id
        ]);

                return  Response::json([
                    "error"=>false,
                    "msg"=>"Successfully Saved"
                ]);

            }else{
                return  Response::json([
                    "error"=>true,
                    "msg"=>"Already Added Coupon"
                ]);
            }


        }else{
          return  Response::json([
                "error"=>true,
                "msg"=>"No Coupon Found"
            ]);
        }



    }
}
