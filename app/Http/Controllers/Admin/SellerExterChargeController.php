<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtraCharge;
use App\Models\SellerExtraCharges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerExterChargeController extends Controller
{



    function Store(Request $request){
        ExtraCharge::create([
            "name"=>$request->name
        ]);


        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }


    function Index(Request $request){
       $data= ExtraCharge::all();


        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function Update($id,Request $request){
        ExtraCharge::where("id",$id)->update([
            "name"=>$request->name
        ]);


        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function Delete($id,Request $request){
        ExtraCharge::where("id",$id)->delete();


        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }


    function StoreExterCharge($id,Request $request){
        SellerExtraCharges::create(["seller_id"=>$id,
            "extra_charge_id"=>$request->charge_id,
            "catagory_id"=>$request->catagory_id,
            "charge_amount"=>$request->charge_amount]);

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }

    function UpdateExterCharge($id,Request $request){
        SellerExtraCharges::where("id",$id)->update([
            "extra_charge_id"=>$request->charge_id,
            "catagory_id"=>$request->catagory_id,
            "charge_amount"=>$request->charge_amount]);

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function FetchExterCharge($id,Request $request){
       $data= SellerExtraCharges::where("id",$id)->get();

        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }


    function DeleterExterCharge($id,Request $request){
        $data= SellerExtraCharges::where("id",$id)->delete();

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }


//
}
