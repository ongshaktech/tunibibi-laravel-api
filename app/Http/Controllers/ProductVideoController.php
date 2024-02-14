<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVideos;
use Illuminate\Http\Request;

class ProductVideoController extends Controller
{

    function AddVideo(Request $request){

        ProductVideos::create([
            "seller_id"=>$request->user()->id,
            "title"=>$request->title,
            "video_link"=>$request->video_link,
            "products"=>json_encode($request->products),
        ]);

        return response()->json([
            "error"=>false,
            "msg"=>"Product Video Added Successfully"
        ]);
    }
    function History(Request $request){

        $data=ProductVideos::where("seller_id",$request->user()->id)->get();


        $info=array();
        for($a=0; $a<count($data); $a++){

            $data_info=[];
            $data_info["title"]=$data[$a]->title;
            $data_info["video_link"]=$data[$a]->video_link;

            $products_array_data=array();

            for($b=0; $b<count(json_decode($data[$a]->products)); $b++){

                $products_array=json_decode($data[$a]->products);
                $products_data=[];
                $p_info=Product::where("id",$products_array[$b])->first();

                if($p_info!=null){
                    $products_data["product_name"]=$p_info->product_name;
                    $products_data["images"]=ProductImage::select("img")->where("product_id",$products_array[$b])->get();
                }
                array_push($products_array_data,$products_data);
            }
            $data_info["products"]=$products_array_data;
            array_push($info,$data_info);
        }

        return  $info;
        return response()->json([
            "error"=>false,
            "data"=>[
                [
                    "title"=>"New Product-1",
                    "desc"=>"ABC",
                    "video_link"=>"https://www.youtube.com",
                    "img"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp-spacegray-select-202206?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1664497359481"
                ],
                [
                    "title"=>"New Product-2",
                    "desc"=>"ABC",
                    "video_link"=>"https://www.youtube.com",
                    "img"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp-spacegray-select-202206?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1664497359481"
                ],
                [
                    "title"=>"New Product-3",
                    "desc"=>"ABC",
                    "video_link"=>"https://www.youtube.com",
                    "img"=>"https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp-spacegray-select-202206?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1664497359481"
                ]
            ]
        ]);
    }
}
