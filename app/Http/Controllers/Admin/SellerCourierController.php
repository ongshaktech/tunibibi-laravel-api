<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerCurierCharges;
use App\Models\SellerPaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerCourierController extends Controller
{

    function Index($id){
        $data=SellerCurierCharges::where(["seller_id"=>$id])->first();
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

    function Store(Request $request){


        foreach($request->courier as $data){

            SellerCurierCharges::insert([
                "seller_id"=>$request->seller_id,
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
    function Update($id,Request $request){
        SellerCurierCharges::where(["id"=>$id])->update([
            "charge"=>$request->charge,
            "above_amount"=>$request->above_amount,
            "courier_details"=>$request->courier_details,
        ]);

        return \Illuminate\Support\Facades\Response::json([
            "error"=>false,
            "msg"=>"Successfully Courier Updated"
        ]);
    }

    function Delete($id,Request $request){
        SellerCurierCharges::where(["id"=>$id])->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }

}
