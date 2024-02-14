<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerPaymentDetails;
use App\Models\SellerPaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerPaymentDetailsController extends Controller
{

    function Index($id){
        $data=SellerPaymentDetails::where("seller_id",$id)->get();


        $new_data=array();

        foreach ($data as $value){

            $method_info=SellerPaymentMethods::where(["id"=>$value->method_id])->first()->method_name;

            array_push($new_data,[
                "id"=>$value->id,
                "method_name"=>$method_info,
                "method_details"=>json_decode($value->method_details)
            ]);
        }


        return Response::json([
            "error"=>false,
            "data"=>$new_data
        ]);
    }
    function Store(Request $request){

        SellerPaymentDetails::create([
            "seller_id"=>$request->seller_id,
            "method_id"=>$request->payment_method_id,
            "method_details"=>json_encode($request->method_details)
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }
    function Update($id,Request $request){

        SellerPaymentDetails::where("id",$id)->update([
            "seller_id"=>$request->seller_id,
            "method_id"=>$request->payment_method_id,
            "method_details"=>json_encode($request->method_details)
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }
    function Delete($id){
       SellerPaymentDetails::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }
}
