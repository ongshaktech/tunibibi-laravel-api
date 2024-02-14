<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BuyerProfileController extends Controller
{

    function Index(Request $request){
        $user=Buyer::where("id",$request->user()->id)->first();

        $user_info=[
            "image"=>$user->image==null?null:config("app.url")."storage/buyer/".$user->image,
            "name"=>$user->name,
            "address"=>$user->address,
            "country"=>$user->country,

            ];

        return Response::json([
            "error"=>false,
            "data"=>$user_info
        ]);
    }

    function Update(Request $request){

        $update_info=[];

        if(!empty($request->name)){
            $update_info["name"]=$request->name;
        }
        if(!empty($request->address)){
            $update_info["address"]=$request->address;
        }
        if(!empty($request->country)){
            $update_info["country"]=$request->country;
        }
        if(!empty($request->image)){
            list($type, $imageData) = explode(';', $request->image);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            Storage::disk("public")->put("buyer/".$fileName,$imageData);
            $update_info["image"]=$fileName;
        }

        Buyer::where("id",$request->user()->id)->update($update_info);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Profile Update"
        ]);

    }

}
