<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\buyer_favourite_product;
use App\Models\Catagory;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SearchHistory;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class FilterControllerController extends Controller
{


    function FilterOptions(){

        $catagory=array();
        $color=array();
        $size=array();


        array_push($color,"Red");
        array_push($color,"Green");
        array_push($color,"Blue");

        array_push($size,"XL");
        array_push($size,"L");
        array_push($size,"M");

        $data=Catagory::all(["id","catagory_name","catagory_img"]);
        foreach ($data as $value){
            array_push($catagory,[
                "id"=>$value->id,
                "catagory_name"=>$value->catagory_name,
                "catagory_img"=>config("app.url")."storage/catagory/".$value->catagory_img,]);

        }


        return Response::json([
            "error"=>false,
            "catagory"=>$catagory,
            "color"=>$color,
            "size"=>$size,
        ]);

    }

    function Filter(Request $request){

        SearchHistory::create([
            "buyer_id"=>$request->user()->id,
            "search_value"=>"",
            "category_name"=>$request->name
        ]);
        $products=Product::all();

        $products_info=array();

        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
            $p_info["product_name"]=$products[$a]->product_name;

            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products[$a]->id,"buyer_id"=>$request->user()->id])->get();

            $images=ProductImage::where("product_id",$products[$a]->id)->first();
            $price=WholesalePrice::where("product_id",$products[$a]->id)->first();
            $sold=Order::where("product_id","like","%".$products[$a]->id."%")->get();


            if($images!=null){
                $p_info["image"]=strval(config("app.url")."storage/products/".$images->img);

            }
            if($price!=null){
                $p_info["price"]=$price->amount;

            }

            $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;


            $p_info["sold"]=count($sold);


            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);
    }
}
