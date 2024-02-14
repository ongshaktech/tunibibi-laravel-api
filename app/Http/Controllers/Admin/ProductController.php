<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catagory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\Seller;
use App\Models\SubCatagory;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    function Index(){

        $products=DB::table("products")->get();

        $products_info=array();

        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
            $p_info["product_name"]=$products[$a]->product_name;
            $p_info["product_name"]=$products[$a]->product_name;

            $catagory=Catagory::where("id",$products[$a]->catagory_id)->get();
            $p_info["catagory"]=$catagory[0];

            $sub_catagory_id=SubCatagory::where("id",$products[$a]->sub_catagory_id)->get();
            $p_info["sub_catagory_id"]=$sub_catagory_id[0];

            $p_info["product_details"]=$products[$a]->product_details;
            $p_info["weight_unit"]=$products[$a]->weight_unit;
            $p_info["weight_type"]=$products[$a]->weight_type;
            $p_info["product_code"]=$products[$a]->product_code;
            $p_info["video_url"]=$products[$a]->video_url;
            $p_info["product_origin"]=$products[$a]->product_origin;

            $wholesale_price=WholesalePrice::where("product_id",$products[$a]->id)->get();
            $p_info["wholesale_price"]=$wholesale_price;

            $product_varient=ProductVarient::where("product_id",$products[$a]->id)->get();

            $data=array();

            foreach ($product_varient as $value){
                array_push($data,["id"=>$value->id,"name"=>$value->name,"color"=>strval(config("app.url")."storage/varients/".$value->color),"varients"=>json_decode($value->varients)]);
            }
            $p_info["product_varient"]=$data;



            $images=ProductImage::where("product_id",$products[$a]->id)->get();

            $data=array();

            foreach ($images as $value){
                array_push($data,["id"=>$value->id,"img"=>strval(config("app.url")."storage/products/".$value->img)]);
            }
            $p_info["images"]=$data;


            $p_info["in_stock"]=$products[$a]->stock;

            $seller=Seller::where("id",$value->seller_id)->first();
            $p_info["seller_info"]=$seller;


            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);

    }
    function Store(Request $request){
        $product_insert=Product::create([
            "seller_id"=>$request->seller_id,
            "product_name"=>$request->product_name,
            "catagory_id"=>$request->catagory_id,
            "sub_catagory_id"=>$request->sub_catagory_id,
            "product_details"=>$request->product_details,
            "product_code"=>$request->product_code,
            "video_url"=>$request->video_url,
            "product_origin"=>$request->product_origin,
            "weight_unit"=>$request->weight_unit,
            "weight_type"=>$request->weight_type,
            "is_active"=>1,
        ]);


        for($i=0; $i<count($request->wholesale_price); $i++){
            $insert_wholesale_prices=WholesalePrice::insert([
                "product_id"=>$product_insert->id,
                "min_quantity"=>$request->wholesale_price[$i]["min_quantity"],
                "max_quantity"=>$request->wholesale_price[$i]["max_quantity"],
                "amount"=>$request->wholesale_price[$i]["amount"],
                "unit"=>$request->wholesale_price[$i]["unit"],
            ]);
        }
        for($i=0; $i<count($request->product_varient); $i++){
            $insert_product_varient=ProductVarient::where(["id"=>$request->product_varient[$i]])->update([
                "product_id"=>$product_insert->id
            ]);
        }

        return response()->json([
            "error"=>false,
            "product_id"=>$product_insert->id,
            "msg"=>"Successfully Product Added"
        ]);
    }
    function Update($id,Request $request){
        $product_insert=Product::where(["id"=>$id])->update([
            "product_name"=>$request->product_name,
            "catagory_id"=>$request->catagory_id,
            "sub_catagory_id"=>$request->sub_catagory_id,
            "product_details"=>$request->product_details,
            "product_code"=>$request->product_code,
            "video_url"=>$request->video_url,
            "product_origin"=>$request->product_origin,
            "weight_unit"=>$request->weight_unit,
            "weight_type"=>$request->weight_type,
            "is_active"=>1,
        ]);


        for($i=0; $i<count($request->wholesale_price); $i++){
            $insert_wholesale_prices=WholesalePrice::updateOrCreate(["product_id"=>$id],[
                "min_quantity"=>$request->wholesale_price[$i]["min_quantity"],
                "max_quantity"=>$request->wholesale_price[$i]["max_quantity"],
                "amount"=>$request->wholesale_price[$i]["amount"],
                "unit"=>$request->wholesale_price[$i]["unit"],
            ]);
        }
        for($i=0; $i<count($request->product_varient); $i++){
            $insert_product_varient=ProductVarient::where(["id"=>$request->product_varient[$i]])->update([
                "product_id"=>$id
            ]);
        }


        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Update"
        ]);
    }
    function Delete($id,){
        Product::where("id",$id)->delete();
        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Deleted"
        ]);
    }
    function StockStatus($id,Request $request){

        Product::where(["id"=>$id])->update(["stock"=>$request->in_stock]);
        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Status Updated"
        ]);
    }

    function SellerProducts($id){

        $products=DB::table("products")->where(["seller_id"=>$id])->get();

        $products_info=array();

        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
            $p_info["product_name"]=$products[$a]->product_name;
            $p_info["product_name"]=$products[$a]->product_name;

            $catagory=Catagory::where("id",$products[$a]->catagory_id)->get();
            $p_info["catagory"]=$catagory[0];

            $sub_catagory_id=SubCatagory::where("id",$products[$a]->sub_catagory_id)->get();
            $p_info["sub_catagory_id"]=$sub_catagory_id[0];

            $p_info["product_details"]=$products[$a]->product_details;
            $p_info["weight_unit"]=$products[$a]->weight_unit;
            $p_info["weight_type"]=$products[$a]->weight_type;
            $p_info["product_code"]=$products[$a]->product_code;
            $p_info["video_url"]=$products[$a]->video_url;
            $p_info["product_origin"]=$products[$a]->product_origin;

            $wholesale_price=WholesalePrice::where("product_id",$products[$a]->id)->get();
            $p_info["wholesale_price"]=$wholesale_price;

            $product_varient=ProductVarient::where("product_id",$products[$a]->id)->get();

            $data=array();

            foreach ($product_varient as $value){
                array_push($data,["id"=>$value->id,"name"=>$value->name,"color"=>strval(config("app.url")."storage/varients/".$value->color),"varients"=>json_decode($value->varients)]);
            }
            $p_info["product_varient"]=$data;



            $images=ProductImage::where("product_id",$products[$a]->id)->get();

            $data=array();

            foreach ($images as $value){
                array_push($data,["id"=>$value->id,"img"=>strval(config("app.url")."storage/products/".$value->img)]);
            }
            $p_info["images"]=$data;


            $p_info["in_stock"]=$products[$a]->stock;

            $seller=Seller::where("id",$value->seller_id)->first();
            $p_info["seller_info"]=$seller;


            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);

    }
}
