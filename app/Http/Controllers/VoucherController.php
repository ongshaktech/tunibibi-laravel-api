<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Coupon;
use App\Models\Voucher;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VoucherController extends Controller
{
    function Index(Request $request){

        $data=Voucher::where(["user_id"=>$request->user()->id,"user_type"=>"buyer","voucher_code"=>$request->voucher])->first();



        if($data!=null){


            if($data["min_amount"]>=$request->product_price){
                return Response::json([
                    "error"=>true,
                    "msg"=>"Sorry! Minimum Price Should Be ".$data["min_amount"]
                ]);
            }
            elseif($data["expire_date"]<=date("Y-m-d")){
                return Response::json([
                    "error"=>true,
                    "msg"=>"Sorry Voucher Was Expired"
                ]);
            }
            elseif($data["is_used"]==1){
                return Response::json([
                    "error"=>true,
                    "msg"=>"Sorry Already Voucher Used"
                ]);
            }else{
            return Response::json([
                "error"=>false,
                "voucher_id"=>$data["id"],
                "disc_amount"=>$data["amount"]
            ]);
            }


        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Sorry!No Voucher Found!"
            ]);
        }



    }
    function all(){
        $data=Voucher::all();

        $response_data=array();

        foreach ($data as $value){

            $buyer=Buyer::where("id",$value->user_id)->first();

            array_push($response_data,[
               "id"=>$value->id,
               "user_info"=>[
                   "id"=>$buyer->id,
                   "name"=>$buyer->name,
               ],
               "voucher_code"=>$value->voucher_code,
               "min_amount"=>$value->min_amount,
               "amount"=>$value->amount,
               "expire_date"=>$value->expire_date,
               "is_used"=>$value->is_used,
            ]);

        }

        return Response::json([
            "error"=>false,
            "data"=>$response_data
        ]);


    }


    function store(Request $request){
        Voucher::create([
            "user_id"=>$request->user_id,
            "user_type"=>"buyer",
            "voucher_code"=>$request->voucher_code,
            "min_amount"=>$request->min_amount,
            "amount"=>$request->amount,
            "expire_date"=>$request->expire_date,
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Stored"
        ]);

    }
    function update($id,Request $request){
        Voucher::where("id",$id)->create([
            "user_id"=>$request->user_id,
            "user_type"=>"buyer",
            "voucher_code"=>$request->voucher_code,
            "min_amount"=>$request->min_amount,
            "amount"=>$request->amount,
            "expire_date"=>$request->expire_date,
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);

    }
    function delete($id,Request $request){
        Voucher::where("id",$id)->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);

    }
}
