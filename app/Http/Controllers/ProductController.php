<?php

namespace App\Http\Controllers;

use App\Models\buyer_favourite_product;
use App\Models\Catagory;
use App\Models\featured_shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\SearchHistory;
use App\Models\SellerFollowers;
use App\Models\SubCatagory;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
{
    function AllProduct(Request $request){

        $products=DB::table("products")->where("seller_id",$request->user()->id)->get();

        $products_info=array();

        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
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










            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);

    }

    function SearchByName(Request $request){
        SearchHistory::create([
            "buyer_id"=>$request->user()->id,
            "search_value"=>$request->name,
            "category_name"=>""
        ]);
        $products=DB::table("products")->where("product_name","like","%".$request->name."%")->get();

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

            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products[$a]->id,"buyer_id"=>$request->user()->id])->get();
            $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $sold=Order::where("product_id","like","%".$products[$a]->id."%")->get();



            $p_info["sold"]=count($sold);

            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);

    }

    function ProductStockStatus($id,Request $request){

        Product::where(["id"=>$id])->update(["stock"=>$request->in_stock]);
        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Status Updated"
        ]);
    }
    function GetProductDetails($id,Request $request){

        $products=DB::table("products")->where(["id"=>$id])->get();

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
                array_push($data,strval(config("app.url")."storage/products/".$value->img));
            }
            $p_info["images"]=$data;


            $p_info["in_stock"]=$products[$a]->stock;










            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);

    }
    function AddProduct(Request $request){
        $product_insert=Product::create([
            "seller_id"=>$request->user()->id,
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

    function AddProductImage(Request $request){

        $image_array=array();

        for($a=0; $a<count($request->image); $a++){

            list($type, $imageData) = explode(';', $request->image[$a]);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);
            $imageData=str_replace("data:image/png;base64,","",$imageData);


            $compressedImage = Image::make($imageData)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode("png", 20); // 75 is the quality percentage


            Storage::disk("public")->put("products/".$fileName,$compressedImage);


            $id= ProductImage::insertGetId([
                "product_id"=>$request->product_id,
                "img"=>$fileName
            ]);



            array_push($image_array,["id"=>$id,"img"=>config("app.url")."storage/products/".$fileName]);
        }

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Image Added",
            "images"=>$image_array
        ]);
    }
    function DeleteProductImage($id,Request $request){

        $images=ProductImage::where("id",$id)->get();

        foreach ($images as $value){
            File::delete(config("app.url")."storage/products/".$value->img);
        }
        ProductImage::where("id",$id)->delete();
        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Image Deleted"
        ]);
    }


    function GetColors(){

        $colors=ProductVarient::all();

        $data_new=array();

        foreach ($colors as $value){

            if(in_array($value,$data_new)==false){
                array_push($data_new,$value->name);
            }

        }

        return Response::json([
            "error"=>false,
            "data"=>$data_new
        ]);

    }


    function UpdateProduct($id,Request $request){
        $product_insert=Product::where(["id"=>$id])->update([
            "seller_id"=>$request->user()->id,
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
            "product_id"=>$id,
            "msg"=>"Successfully Product Update"
        ]);
    }
    function AddDraftProduct(Request $request){
        $product_insert=Product::create([
            "seller_id"=>$request->user()->id,
            "product_name"=>$request->product_name,
            "catagory_id"=>$request->catagory_id,
            "sub_catagory_id"=>$request->sub_catagory_id,
            "product_details"=>$request->product_details,
            "product_code"=>$request->product_code,
            "video_url"=>$request->video_url,
            "product_origin"=>$request->product_origin,
            "weight_unit"=>$request->weight_unit,
            "weight_type"=>$request->weight_type,
            "is_active"=>0,
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


    function  AddVarient(Request $request){


        list($type, $imageData) = explode(';', $request->color);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("varients/".$fileName,$imageData);

        $data_insert=ProductVarient::create([
            "user_id"=>$request->user()->id,
            "name"=>$request->name,
            "color"=>$fileName,
            "varients"=>json_encode($request->varients)
        ]);


        $data=ProductVarient::where("id",$data_insert->id)->get();

        $all_varients=array();

        foreach ($data as $d){
            $new_a=["id"=>$d->id,"name"=>$d->name,"color"=>config("app.url")."storage/varients/".$d->color,"varients"=>json_decode($d->varients)];
            array_push($all_varients,$new_a);

        }

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Image Added",
            "data"=>$all_varients
        ]);

    }

    function UpdateVarient($id,Request $request){
        $all_varients=array();
        if($request->color!=null && !empty($request->color)){
            list($type, $imageData) = explode(';', $request->color);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            $data=ProductVarient::where("id",$id)->get();

            foreach ($data as $datas){
                File::delete(config("app.url")."storage/varients/".$datas->color);
            }


            Storage::disk("public")->put("varients/".$fileName,$imageData);
            $data_insert=ProductVarient::where(["id"=>$id])->update([
                "user_id"=>$request->user()->id,
                "name"=>$request->name,
                "color"=>$fileName,
                "varients"=>json_encode($request->varients)
            ]);

        }else{
            $data_insert=ProductVarient::where(["id"=>$id])->update([
                "user_id"=>$request->user()->id,
                "name"=>$request->name,
                "varients"=>json_encode($request->varients)
            ]);

        }


        $data=ProductVarient::where("id",$id)->get();



        foreach ($data as $d){

            $new_a=["id"=>$d->id,"name"=>$d->name,"color"=>config("app.url")."storage/varients/".$d->color,"varients"=>json_decode($d->varients)];

            array_push($all_varients,$new_a);


        }



        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Updated",
            "data"=>$all_varients
        ]);

    }

    function DeleteVarient($id,Request $request){

        $data=ProductVarient::where("id",$id)->get();

        foreach ($data as $datas){
            File::delete(config("app.url")."storage/varients/".$datas->color);
        }



        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);

    }
    function GetVarient(Request $request){
        $all_data=ProductVarient::where(["user_id"=>$request->user()->id])->orderBy("id","DESC")->get();

        $data=array();

        foreach ($all_data as $value){
            array_push($data,["id"=>$value->id,"name"=>$value->name,"color"=>strval(config("app.url")."storage/varients/".$value->color),"varients"=>json_decode($value->varients)]);
        }

        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }


    function DeleteProduct($id,Request $request){
        Product::where("id",$id)->delete();
        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Deleted"
        ]);
    }










    //Buyer Part
    function GetBuyerHomeProducts(Request $request){
        $products=Product::all();

        $products_info=array();

        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
            $p_info["product_name"]=$products[$a]->product_name;


            $images=ProductImage::where("product_id",$products[$a]->id)->first();
            $price=WholesalePrice::where("product_id",$products[$a]->id)->first();
            $sold=Order::where("product_id","like","%".$products[$a]->id."%")->get();


            if($images!=null){
                $p_info["image"]=strval(config("app.url")."storage/products/".$images->img);

            }
            if($price!=null){
                $p_info["price"]=$price->amount;

            }

            $today=date("Y-m-d");

            $disc_price=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$products[$a]->id)->first();

            if($disc_price!=null){
                $disc_info=json_decode($disc_price->wholesale_price_id)[0]->amount;
                $p_info["disc_price"]=$disc_info;
                $p_info["disc_percent"]=20;
            }else{
                $p_info["disc_price"]=0;
                $p_info["disc_percent"]=0;
            }



            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products[$a]->id,"buyer_id"=>$request->user()->id])->get();
            $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $sold=Order::where("product_id","like","%".$products[$a]->id."%")->get();
            $p_info["sold"]=count($sold);


            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);
    }
    function FeaturedProducts(Request $request){
        $data=featured_shop::where("country",$request->user()->country)->get();

        $products_info=array();

        foreach ($data as $value){

            $products_data=array();
            $products_fetch=json_decode($value->products_id);

            $products_fetch=Product::whereIn("id",$products_fetch)->get();

            for($a=0; $a<count($products_fetch); $a++){
                $p_info=[];
                $p_info["id"]=$products_fetch[$a]->id;
                $p_info["shop_id"]=$products_fetch[$a]->shop_id;
                $p_info["product_name"]=$products_fetch[$a]->product_name;


                $images=ProductImage::where("product_id",$products_fetch[$a]->id)->first();

                if($images!=null){
                    $p_info["image"]=strval(config("app.url")."storage/products/".$images->img);

                }
                $price=WholesalePrice::where("product_id",$products_fetch[$a]->id)->first();

                if($price!=null){
                    $p_info["price"]=$price->amount;

                }

                $today=date("Y-m-d");

                $disc_price=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$products_fetch[$a]->id)->first();

                if($disc_price!=null){
                    $disc_info=json_decode($disc_price->wholesale_price_id)[0]->amount;
                    $p_info["disc_price"]=$disc_info;
                    $p_info["disc_percent"]=20;
                }else{
                    $p_info["disc_price"]=0;
                    $p_info["disc_percent"]=0;
                }



                $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products_fetch[$a]->id,"buyer_id"=>$request->user()->id])->get();
                $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;
                $sold=Order::where("product_id","like","%".$products_fetch[$a]->id."%")->get();

                $p_info["sold"]=count($sold);


                array_push($products_data,$p_info);

            }

            $shop_info=\App\Models\Seller::where("id",$value->shop_id)->first();
            $shop_views=DB::table("shop_views")->where("shop_id",$value->shop_id)->count();
            $shop=[
                "shop_name"=>$shop_info->shop_name,
                "logo"=>config("app.url")."storage/logo/".$shop_info->logo,
                "views"=>$shop_views
            ];



            array_push($products_info,[
                "shop_id"=>$value->shop_id,
                "shop_info"=>$shop,
                "views"=>$shop_views,
//                "video"=>config("app.url")."storage/featured_videos/".$value->videos,
                "video"=>config("app.url")."storage/featured_videos/abc.mp4",
                "products"=>$products_data,
                "created_at"=>$value->created_at
            ]);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);
    }

    function SubCatagoryWiseProducts($id,Request $request){
        $products=Product::where(["sub_catagory_id"=>$id])->get();

        $products_info=array();

        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
            $p_info["product_name"]=$products[$a]->product_name;


            $images=ProductImage::where("product_id",$products[$a]->id)->first();
            $price=WholesalePrice::where("product_id",$products[$a]->id)->first();
            $sold=Order::where("product_id","like","%".$products[$a]->id."%")->get();


            if($images!=null){
                $p_info["image"]=strval(config("app.url")."storage/products/".$images->img);

            }
            if($price!=null){
                $p_info["price"]=$price->amount;

            }



            $today=date("Y-m-d");

            $disc_price=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$products[$a]->id)->first();

            if($disc_price!=null){
                $disc_info=json_decode($disc_price->wholesale_price_id)[0]->amount;
                $p_info["disc_price"]=$disc_info;
                $p_info["disc_percent"]=20;
            }else{
                $p_info["disc_price"]=0;
                $p_info["disc_percent"]=0;
            }



            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products[$a]->id,"buyer_id"=>$request->user()->id])->get();
            $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $sold=Order::where("product_id","like","%".$products[$a]->id."%")->get();
            $p_info["sold"]=count($sold);


            array_push($products_info,$p_info);

        }

        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);
    }
}
