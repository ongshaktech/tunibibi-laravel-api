<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\SubCatagory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SubCatagoryController extends Controller
{
    function index(){
        $data=SubCatagory::all();
        $new_array=array();
        foreach ($data as $value){
            array_push($new_array,[
                "id"=>$value->id,
                "catagory_name"=>Catagory::where("id",$value->catagory_id)->first()->catagory_name,
                "sub_catagory_name"=>$value->sub_catagory_name,
                "image"=>config("app.url")."storage/sub-catagory/".$value->sub_catagory_img
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

        Storage::disk("public")->put("sub-catagory/".$fileName,$imageData);

        SubCatagory::create(["catagory_id"=>$request->catagory_id,"sub_catagory_name"=>$request->sub_catagory_name,"sub_catagory_img"=>$fileName]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Sub Catagory Added"]);
    }
    function update($id,Request $request){
        list($type, $imageData) = explode(';', $request->image);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        $old_image=SubCatagory::where("id",$id)->first();
        File::delete(config("app.url")."storage/sub-catagory/".$old_image->sub_catagory_img);
        Storage::disk("public")->put("sub-catagory/".$fileName,$imageData);
        SubCatagory::where("id",$id)->update(["catagory_id"=>$request->catagory_id,"sub_catagory_name"=>$request->sub_catagory_name,"sub_catagory_img"=>$fileName]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Sub Category Updated"]);


    }
    function delete($id){
        SubCatagory::where("id",$id)->delete();
        return Response()->json(["error"=>false,"msg"=>"Successfully Sub Category Deleted"]);
    }
}
