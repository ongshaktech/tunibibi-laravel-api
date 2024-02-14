<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\buyer_banners;
use Illuminate\Http\Request;

class BuyerBannersController extends Controller
{
    function Index(){


        $data=buyer_banners::get();

        if($data!=null){

            $banners=array();

            for($a=0; $a<count($data); $a++){
                array_push($banners,config("app.url")."storage/buyer_banners/".$data[$a]["image"]);
            }

            return response()->json([
                "error"=>false,
                "data"=>$banners
            ]);
        }else{
            return response()->json([
                "error"=>true,
                "msg"=>"Opps! Something is wrong!"
            ]);
        }


    }
}
