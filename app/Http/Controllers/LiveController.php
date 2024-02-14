<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Live;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\SubCatagory;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LiveController extends Controller
{
    function LiveStart(Request $request){
        Live::create([
            "seller_id"=>$request->user()->id,
            "title"=>$request->title,
            "fb_rtmp"=>$request->fb_rtmp,
            "youtube_rtmp"=>$request->youtube_rtmp,
            "products"=>json_encode($request->products)
        ]);

        return response()->json([
            "error"=>false,
            "msg"=>"Live Started"
        ]);
    }
    function LiveEnd($id,Request $request){
        Live::where(["seller_id"=>$request->user()->id,"id"=>$id])->update(["is_ended"=>1]);

        return response()->json([
            "error"=>false,
            "msg"=>"Live Ended"
        ]);
    }


    function AllHistory(Request $request){

        $data=Live::where("seller_id",$request->user()->id)->get();
        $products=array();

        for($a=0; $a<count($data); $a++){


            $product_info=[];
            $product_info["title"]=$data[$a]->title;
            $product_info["fb_rtmp"]=$data[$a]->fb_rtmp;
            $product_info["youtube_rtmp"]=$data[$a]->youtube_rtmp;
            $product_info["products"]=array();
            $live_p=json_decode($data[$a]["products"]);

            $all_p_info=DB::table("products")->whereIn("id",$live_p)->get();

            for($b=0; $b<count($all_p_info); $b++){
                $p_info=[];
                $p_info["id"]=$all_p_info[$b]->id;
                $p_info["product_name"]=$all_p_info[$b]->product_name;
                $p_info["product_name"]=$all_p_info[$b]->product_name;

                $catagory=Catagory::where("id",$all_p_info[$b]->catagory_id)->get();
                $p_info["catagory"]=$catagory;

                $sub_catagory_id=SubCatagory::where("id",$all_p_info[$b]->sub_catagory_id)->get();
                $p_info["sub_catagory_id"]=$sub_catagory_id;

                $p_info["product_details"]=$all_p_info[$b]->product_details;
                $p_info["weight_unit"]=$all_p_info[$b]->weight_unit;
                $p_info["product_code"]=$all_p_info[$b]->product_code;
                $p_info["video_url"]=$all_p_info[$b]->video_url;
                $p_info["product_origin"]=$all_p_info[$b]->product_origin;

                $wholesale_price=WholesalePrice::where("product_id",$all_p_info[$b]->id)->get();
                $p_info["wholesale_price"]=$wholesale_price;

                $product_varient=ProductVarient::where("product_id",$all_p_info[$b]->id)->get();
                $p_info["product_varient"]=$product_varient;

                $images=ProductImage::where("product_id",$all_p_info[$b]->id)->get();
                $p_info["images"]=$images;


                array_push($product_info["products"],$p_info);

            }

            array_push($products,$product_info);
        }

        return  $products;

    }
}
