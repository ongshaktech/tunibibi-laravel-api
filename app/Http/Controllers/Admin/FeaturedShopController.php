<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\buyer_favourite_product;
use App\Models\featured_shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class FeaturedShopController extends Controller
{

    function Index(){
        $data=featured_shop::all();

        $products_info=array();

        foreach ($data as $value){


            array_push($products_info,[
                "id"=>$value->id,
                "shop_id"=>$value->shop_id,
                "video"=>$value->video,
                "products_id"=>json_decode($value->products_id),
                "country"=>$value->country,
            ]);

        }



//        $p_info["image"]=strval(config("app.url")."storage/products/".$images->img);
        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);
    }

   function Store(Request $request){

       featured_shop::create([
           "shop_id"=>$request->shop_id,
           "video"=>$request->video,
           "products_id"=>json_encode($request->products_id),
           "country"=>$request->country
       ]);

       return Response::json([
           "error"=>false,
           "msg"=>"Successfully Stored"
       ]);

   }
    function Update($id,Request $request){

        featured_shop::where("id",$id)->update([
            "shop_id"=>$request->shop_id,
            "video"=>$request->video,
            "products_id"=>json_encode($request->products_id),
            "country"=>$request->country
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);

    }
    function Delete($id,Request $request){
        featured_shop::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Deleted"
        ]);

    }

}
