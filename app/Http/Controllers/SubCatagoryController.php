<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\SubCatagory;
use Illuminate\Http\Request;

class SubCatagoryController extends Controller
{
    function GetSubCatagory($id){
        $data=SubCatagory::where("catagory_id",$id)->get(["id","sub_catagory_name","sub_catagory_img"]);

        $new_array=array();
        foreach ($data as $value){
            array_push($new_array,[
                "id"=>$value->id,
                "sub_catagory_name"=>$value->sub_catagory_name,
                "sub_catagory_img"=>config("app.url")."storage/seller/banner/".$value->sub_catagory_img,]);

        }

        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }
}
