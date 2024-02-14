<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerPaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerPaymentMethodController extends Controller
{

    public function Index(){
        $payment_info=array();
        $data=SellerPaymentMethods::all();
        foreach ($data as $value){
            array_push($payment_info,["id"=>$value->id,"method_name"=>$value->method_name,"method_details"=>json_decode($value->method_details)]);
        }
        return Response::json([
            "error"=>false,
            "data"=>$payment_info
        ]);
    }
    function Store(Request $request){
        SellerPaymentMethods::create([
            "method_name"=>$request->name,
                "method_details"=>json_encode($request->details)
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Stored"
        ]);
    }

    function Update($id,Request $request){
        SellerPaymentMethods::where(["id"=>$id])->update([
            "method_name"=>$request->name,
            "method_details"=>json_encode($request->details)
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function Delete($id,Request $request){
        SellerPaymentMethods::where(["id"=>$id])->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }
}
