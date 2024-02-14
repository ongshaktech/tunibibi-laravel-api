<?php

namespace App\Http\Controllers;

use App\Models\buyer_shipping_address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BuyerShippingAddressController extends Controller
{


    function Index(Request $request){
        $data=buyer_shipping_address::where(["buyer_id"=>$request->user()->id])->get();
        return Response::json([
            "error"=>true,
            "data"=>$data
        ]);

    }

    function Create(Request $request){
        if($request->is_default==1){
            buyer_shipping_address::where("buyer_id",$request->user()->id)->update(["is_default"=>0]);
        }
      $status=buyer_shipping_address::create([
            "name1"=>$request->name1,
            "name2"=>$request->name2,
            "mobile"=>$request->mobile,
            "street"=>$request->street,
            "apartment"=>$request->apartment,
            "country"=>$request->country,
            "state"=>$request->state,
            "city"=>$request->city,
            "zip"=>$request->zip,
            "is_default"=>$request->is_default,
            "buyer_id"=>$request->user()->id
            ]);

      if($status!=null){

          return Response::json([
              "error"=>false,
              "msg"=>"Successfully Saved"
          ]);
      }else{
          return Response::json([
              "error"=>true,
              "msg"=>"Opps!Something Wrong"
          ]);
      }

    }

    function Update($id,Request $request){
        if($request->is_default==1){
            buyer_shipping_address::where("buyer_id",$request->user()->id)->update(["is_default"=>0]);
        }
        $status=buyer_shipping_address::where(["id"=>$id])->update([
            "name1"=>$request->name1,
            "name2"=>$request->name2,
            "mobile"=>$request->mobile,
            "street"=>$request->street,
            "apartment"=>$request->apartment,
            "country"=>$request->country,
            "state"=>$request->state,
            "city"=>$request->city,
            "zip"=>$request->zip,
            "is_default"=>$request->is_default,
            "buyer_id"=>$request->user()->id
        ]);

        if($status!=null){

            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Updated"
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Opps!Something Wrong"
            ]);
        }

    }


    function GetDefaultShipping(Request $request){

        $data=buyer_shipping_address::where(["buyer_id"=>$request->user()->id,"is_default"=>1])->get();
        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function DefaultShipping(Request $request){

        buyer_shipping_address::where("buyer_id",$request->user()->id)->update(["is_default"=>0]);
        buyer_shipping_address::where("id",$request->id)->update(["is_default"=>1]);
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Save as Default Shipping Address"
        ]);
    }

}
