<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Catagory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CatagoryController extends Controller
{
    function index(){
        $data=Catagory::all();
        $new_array=array();
        foreach ($data as $value){
            array_push($new_array,[
                "id"=>$value->id,
                "name"=>$value->catagory_name,
                "image"=>config("app.url")."storage/catagory/".$value->catagory_img
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

        Storage::disk("public")->put("catagory/".$fileName,$imageData);

        Catagory::create(["catagory_name"=>$request->name,"catagory_img"=>$fileName]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Catagory Added"]);
    }
    function update($id,Request $request){
        list($type, $imageData) = explode(';', $request->image);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        $old_image=Catagory::where("id",$id)->first();
        File::delete(config("app.url")."storage/catagory/".$old_image->catagory_img);
        Storage::disk("public")->put("catagory/".$fileName,$imageData);
        Catagory::where("id",$id)->update(["catagory_name"=>$request->name,"catagory_img"=>$fileName]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Category Updated"]);


    }
    function delete($id){
        Catagory::where("id",$id)->delete();
        return Response()->json(["error"=>false,"msg"=>"Successfully Category Deleted"]);
    }
}
