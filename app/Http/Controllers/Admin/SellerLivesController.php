<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\Live;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerLivesController extends Controller
{
    function Index(){
        $data=Live::all();


        $new_data=array();
        foreach ($data as $value){


            $seller_info=Seller::where("id",$value->seller_id)->first();
            $seller_data=array();

            array_push($seller_data,[
                "id"=> $seller_info->id,
                "shop_name"=> $seller_info->shop_name,
                "phone"=>$seller_info->phone,
                "business_type_name"=> BusinessType::where("id",$seller_info->business_type_id)->first()->name,
                "address"=>$seller_info->address,
                "slug"=>$seller_info->slug,
                "email"=>$seller_info->email,
                "logo"=>config("app.url")."storage/logo/".$seller_info->logo
            ]);

            array_push($new_data,[
                "seller_info"=>$seller_data,
                "live_info"=>[
                    "id"=>$value->id,
                    "seller_id"=>$value->seller_id,
                    "fb_rtmp"=>$value->fb_rtmp,
                    "youtube_rtmp"=>$value->youtube_rtmp,
                    "products"=>json_decode($value->products),
                    "is_ended"=>$value->is_ended,
                    "created_at"=>$value->created_at,
                    "updated_at"=>$value->updated_at,
                ]
            ]);
        }


        return Response::json([
            "error"=>false,
            "data"=>$new_data
        ]);

    }

    function SellerTotalLives($id){
        $data=Live::where("seller_id",$id)->get();


        $new_data=array();
        foreach ($data as $value){


            $seller_info=Seller::where("id",$value->seller_id)->first();
            $seller_data=array();

            array_push($seller_data,[
                "id"=> $seller_info->id,
                "shop_name"=> $seller_info->shop_name,
                "phone"=>$seller_info->phone,
                "business_type_name"=> BusinessType::where("id",$seller_info->business_type_id)->first()->name,
                "address"=>$seller_info->address,
                "slug"=>$seller_info->slug,
                "email"=>$seller_info->email,
                "logo"=>config("app.url")."storage/logo/".$seller_info->logo
            ]);

            array_push($new_data,[
                "seller_info"=>$seller_data,
                "live_info"=>[
                    "id"=>$value->id,
                    "seller_id"=>$value->seller_id,
                    "fb_rtmp"=>$value->fb_rtmp,
                    "youtube_rtmp"=>$value->youtube_rtmp,
                    "products"=>json_decode($value->products),
                    "is_ended"=>$value->is_ended,
                    "created_at"=>$value->created_at,
                    "updated_at"=>$value->updated_at,
                ]
            ]);
        }


        return Response::json([
            "error"=>false,
            "data"=>$new_data
        ]);

    }
}
