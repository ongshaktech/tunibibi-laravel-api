<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerReferPolicy;
use App\Models\TunibibiAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SettingsController extends Controller
{
    function Index(){
        $data_info=TunibibiAddress::all();

        return Response::json([
            "error"=>false,
            "data"=>$data_info
        ]);
    }

    function Store(Request $request){
        TunibibiAddress::create([
            "name"=>$request->name,
            "mobile"=>$request->mobile,
            "street"=>$request->street,
            "apartment"=>$request->apartment,
            "country"=>$request->country,
            "state"=>$request->state,
            "city"=>$request->city,
            "zip"=>$request->zip
        ]);
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Saved"
        ]);

    }
    function Update($id,Request $request){
        TunibibiAddress::where("id",$id)->update([
            "name"=>$request->name,
            "mobile"=>$request->mobile,
            "street"=>$request->street,
            "apartment"=>$request->apartment,
            "country"=>$request->country,
            "state"=>$request->state,
            "city"=>$request->city,
            "zip"=>$request->zip
        ]);
        return Response::json([
            "error"=>false,
            "msg"=>"Succssfully Updated"
        ]);

    }
    function Delete($id,Request $request){
        TunibibiAddress::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Deleted"
        ]);

    }
}
