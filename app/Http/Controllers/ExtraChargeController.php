<?php

namespace App\Http\Controllers;

use App\Models\ExtraCharge;
use App\Models\SellerExtraCharges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExtraChargeController extends Controller
{

    function GetExtraCharges(Request $request){

        $data=ExtraCharge::all();
        return Response::json([
            "error"=>false,
            "charges"=>$data
        ]);
    }
    function PostExtraCharges(Request $request){

        $check=SellerExtraCharges::where(["seller_id"=>$request->user()->id,"extra_charge_id"=>$request->charge_id])->get();

        if(count($check)>0){
            SellerExtraCharges::where(["seller_id"=>$request->user()->id,"extra_charge_id"=>$request->charge_id])->update(["seller_id"=>$request->user()->id,
                "extra_charge_id"=>$request->charge_id,
                "catagory_id"=>$request->catagory_id,
                "charge_amount"=>$request->charge_amount]);

            return response()->json([
                "error"=>false,
                "msg"=>"Successfully Updated"
            ]);
        }else{
            SellerExtraCharges::create(["seller_id"=>$request->user()->id,
                "extra_charge_id"=>$request->charge_id,
                "catagory_id"=>$request->catagory_id,
                "charge_amount"=>$request->charge_amount]);

            return response()->json([
                "error"=>false,
                "msg"=>"Successfully Saved"
            ]);

        }

    }

}
