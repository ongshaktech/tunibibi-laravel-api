<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;

class Seller extends Controller
{

    function LogoUpdate($id,Request $request){

     if($request->has("logo")){
         $image=$request->logo;
         $image_name=time().".".$image->getClientOriginalExtension();
         $image->move(public_path("logo"),$image_name);
         $status=\App\Models\Seller::where("id",$id)->update(["logo"=>$image_name]);

         if($status==1){
             return Response::json([
                 "error"=>false,
                 "msg"=>"Successfully Logo Uploaded",
             ]);
         }
     }

    }

    function QrCode(Request $request){

        $data=\App\Models\Seller::where("id",$request->user()->id)->first();

        return Response::json([
            "error"=>false,
            "shop_slug"=>$data->slug
        ]);
    }

    function Edit(Request $request){

        if(
            count(\App\Models\Seller::where([
            ["id","!=",$request->user()->id]])->get())==0
        ){
            return Response::json([
                "error"=>true,
                "msg"=>"Already Number Used",
            ]);
        }
        else if(
            count(\App\Models\Seller::where([
                ["id","!=",$request->user()->id],
                ["email","=",$request->email]
            ])->get())>0
        ){
            return Response::json([
                "error"=>true,
                "msg"=>"Already Email Used",
            ]);
        }else{
             if(empty($request->logo) || $request->logo==null || $request->logo=="null"){

                $slug=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->shop_name)));
                $status= \App\Models\Seller::where(["id"=>$request->user()->id])->update([
                    "email"=>$request->email,
                    "shop_name"=>$request->shop_name,
                    "business_type_id"=>$request->business_type_id,
                    "address"=>$request->address,
                    "slug"=>$slug
                ]);

                return Response::json([
                    "error"=>false,
                    "msg"=>"Successfully Business Updated"
                ]);
            }else{
                list($type, $imageData) = explode(';', $request->logo);
                list(,$extension) = explode('/',$type);
                list(,$imageData)      = explode(',', $imageData);
                $fileName = uniqid().'.'.$extension;
                $imageData = base64_decode($imageData);

                Storage::disk("public")->put("logo/".$fileName,$imageData);

                $slug=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->shop_name)));
                $status= \App\Models\Seller::where(["id"=>$request->user()->id])->update([
                    "email"=>$request->email,
                    "shop_name"=>$request->shop_name,
                    "business_type_id"=>$request->business_type_id,
                    "address"=>$request->address,
                    "slug"=>$slug,
                    "logo"=>$fileName
                ]);

                return Response::json([
                    "error"=>false,
                    "msg"=>"Successfully Business Updated"
                ]);
            }

        }



    }
}
