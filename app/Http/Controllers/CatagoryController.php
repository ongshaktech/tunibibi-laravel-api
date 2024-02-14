<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\SubCatagory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatagoryController extends Controller
{
    function AllCatagory(){

        $catagory_tree=array();
        $data=Catagory::all();

        for($a=0; $a<count($data); $a++){
            $catagory=["id"=>$data[$a]->id,"catagory_name"=>$data[$a]->catagory_name];

            $sub_catagory=SubCatagory::where("catagory_id",$data[$a]->id)->get();

            $sub_catagory_array=array();

            for($b=0; $b<count($sub_catagory); $b++){
                array_push($sub_catagory_array,[
                    "id"=>$sub_catagory[$b]->id,
                    "sub_catagory_name"=>$sub_catagory[$b]->sub_catagory_name,
                    "sub_catagory_img"=>config("app.url")."storage/sub-catagory/".$sub_catagory[$b]->sub_catagory_img,
                ]);
            }

            $catagory["SubCatagory"]=$sub_catagory_array;
            array_push($catagory_tree,$catagory);
        }


        return response()->json([
            "error"=>false,
            "data"=>$catagory_tree
        ]);
    }


    function Catagory(){
        $data=Catagory::all(["id","catagory_name","catagory_img"]);
        $new_array=array();
        foreach ($data as $value){
            array_push($new_array,[
                "id"=>$value->id,
            "catagory_name"=>$value->catagory_name,
            "catagory_img"=>config("app.url")."storage/catagory/".$value->catagory_img,]);

        }
        return response()->json([
            "error"=>false,
            "data"=>$new_array
        ]);
    }
}
