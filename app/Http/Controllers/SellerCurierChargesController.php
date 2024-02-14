<?php

namespace App\Http\Controllers;

use App\Models\SellerCurierCharges;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SellerCurierChargesController extends Controller
{




    function Index(Request $request){
        $data=SellerCurierCharges::where(["seller_id"=>$request->user()->id])->get();

        $courier_info=array();

        foreach($data as $value){
            array_push($courier_info,[
                "id"=>$value->id,
                "charge"=>$value->charge,
                "name"=>$value->courier_details
            ]);
        }

        return \Illuminate\Support\Facades\Response::json([
            "error"=>false,
            "data"=>$courier_info
        ]);
    }


    function AddCurrierCharge(Request $request){


        foreach($request->courier as $data){

            SellerCurierCharges::insert([
                "seller_id"=>$request->user()->id,
                "charge"=>$data["charge"],
                "above_amount"=>$data["above_amount"],
                "courier_details"=>$data["courier_details"],
            ]);
        }

        return \Illuminate\Support\Facades\Response::json([
            "error"=>false,
            "msg"=>"Successfully Courier Added"
        ]);
    }
    function EditCurrierCharge(Request $request){
        SellerCurierCharges::where(["seller_id"=>$request->user()->id])->update([
            "charge"=>$request->charge,
            "above_amount"=>$request->above_amount,
            "courier_details"=>$request->courier_details,
        ]);

        return \Illuminate\Support\Facades\Response::json([
            "error"=>false,
            "msg"=>"Successfully Courier Updated"
        ]);
    }

    function GetCurrierCharge(Request $request){
        $data=SellerCurierCharges::where(["seller_id"=>$request->user()->id])->first();
        return \Illuminate\Support\Facades\Response::json([
            "error"=>false,
            "data"=>[
                "id"=>$data->id,
                "charge"=>$data->charge,
                "above_amount"=>$data->above_amount,
                "courier_details"=>$data->courier_details,
            ]
        ]);
    }

}
