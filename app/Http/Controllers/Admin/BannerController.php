<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    function index(){
        $data=Banner::all();

        $new_array=array();

        foreach ($data as $value){

            array_push($new_array,[
                "id"=>$value->id,
                "image"=>config("app.url")."storage/seller/banner/".$value->image
            ]);
        }

        return Response()->json(["error"=>false,"data"=>$new_array]);
    }
    function create(Request $request){
        list($type, $imageData) = explode(';', $request->image);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("seller/banner/".$fileName,$imageData);

        Banner::create(["image"=>$fileName]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Banner Added"]);
    }
    function update($id,Request $request){
        list($type, $imageData) = explode(';', $request->image);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);


        $old_banner=Banner::where("id",$id)->first();
        File::delete(config("app.url")."storage/seller/banner/".$old_banner->image);

        Storage::disk("public")->put("seller/banner/".$fileName,$imageData);

        Banner::where("id",$id)->update(["image"=>$fileName]);


        return Response()->json(["error"=>false,"msg"=>"Successfully Banner Updated"]);


    }
    function delete($id){

        Banner::where("id",$id)->delete();
        return Response()->json(["error"=>false,"msg"=>"Successfully Banner Deleted"]);
    }
}
