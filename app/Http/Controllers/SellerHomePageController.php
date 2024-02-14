<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\buyer_favourite_product;
use App\Models\featured_shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SellerFollowers;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SellerHomePageController extends Controller
{


    function Show($id,Request $request){
        $new_data=[];
        $data=\App\Models\Seller::where("id",$id)->first();

        $new_data["postive"]=20;
        $new_data["follower"]=SellerFollowers::where("seller_id",$id)->count();
        $flag_url=DB::table("country")->where("name",$data->country)->first()->flag;
        $new_data["country"]=config("app.url")."storage/flag/".$flag_url;
        $new_data["shop_name"]=$data->shop_name;
        $new_data["logo"]=config("app.url")."storage/business/".$data->image;
        //Featured Products

        $datas=featured_shop::where("shop_id",$id)->get();
        $featured_products=array();
        foreach ($datas as $value){

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



            array_push($featured_products,[
                "shop_id"=>$value->shop_id,
                "shop_info"=>$shop,
                "views"=>$shop_views,
                "video"=>config("app.url")."storage/featured_videos/".$value->videos,
                "products"=>$products_data,
                "created_at"=>$value->created_at
            ]);

        }


        $products_fetch=Product::where("Seller_id",$id)->latest()->limit(10)->get();


        $products=array();

        for($a=0; $a<count($products_fetch); $a++){
            $p_information=[];
            $p_information["id"]=$products_fetch[$a]->id;
            $p_information["product_name"]=$products_fetch[$a]->product_name;

            $images=ProductImage::where("product_id",$products_fetch[$a]->id)->first();
            $price=WholesalePrice::where("product_id",$products_fetch[$a]->id)->first();
            $sold=Order::where("product_id","like","%".$products_fetch[$a]->id."%")->get();


            if($images!=null){
                $p_information["image"]=strval(config("app.url")."storage/products/".$images->img);

            }
            if($price!=null){
                $p_information["price"]=$price->amount;

            }

            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products_fetch[$a]->id,"buyer_id"=>$request->user()->id])->get();
            $p_information["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $p_information["sold"]=count($sold);


            array_push($products,$p_information);

        }
        $new_data["featured"]=$featured_products;
        $new_data["products"]=$products;

        $last_buy=Order::where("product_id","like","%".$id."%")->latest()->first();

        if($last_buy!=null){
            $buyer=Buyer::where(["id"=>$last_buy->buyer_id])->first();

            $new_data["last_buy_user"]=$buyer->name;


            $new_data["last_buy_quantity"]=$last_buy->quantity;

        }else{
            $new_data["last_buy"]=null;
        }

        $check_is_following=SellerFollowers::where(["seller_id"=>$id,"buyer_id"=>$request->user()->id])->get();

        if(count($check_is_following)>0){
            $new_data["is_following"]=true;
        }else{
            $new_data["is_following"]=false;
        }


        return Response::json([
            "error"=>false,
            "data"=>$new_data
        ]);
    }

    function AllProducts($id,Request $request){
        $products_fetch=Product::where("Seller_id",$id)->get();


        $products=array();

        for($a=0; $a<count($products_fetch); $a++){
            $p_information=[];
            $p_information["id"]=$products_fetch[$a]->id;
            $p_information["product_name"]=$products_fetch[$a]->product_name;

            $images=ProductImage::where("product_id",$products_fetch[$a]->id)->first();
            $price=WholesalePrice::where("product_id",$products_fetch[$a]->id)->first();
            $sold=Order::where("product_id","like","%".$products_fetch[$a]->id."%")->get();


            if($images!=null){
                $p_information["image"]=strval(config("app.url")."storage/products/".$images->img);

            }
            if($price!=null){
                $p_information["price"]=$price->amount;

            }
            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products_fetch[$a]->id,"buyer_id"=>$request->user()->id])->get();
            $p_information["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $p_information["sold"]=count($sold);


            array_push($products,$p_information);

        }

        return Response::json([
            "errpr"=>false,
            "data"=>$products
        ]);


    }
    function NewProducts($id,Request $request){
        $products_fetch=Product::where("Seller_id",$id)->latest()->get();


        $products=array();

        for($a=0; $a<count($products_fetch); $a++){
            $p_information=[];
            $p_information["id"]=$products_fetch[$a]->id;
            $p_information["product_name"]=$products_fetch[$a]->product_name;

            $images=ProductImage::where("product_id",$products_fetch[$a]->id)->first();
            $price=WholesalePrice::where("product_id",$products_fetch[$a]->id)->first();
            $sold=Order::where("product_id","like","%".$products_fetch[$a]->id."%")->get();


            if($images!=null){
                $p_information["image"]=strval(config("app.url")."storage/products/".$images->img);

            }
            if($price!=null){
                $p_information["price"]=$price->amount;

            }
            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$products_fetch[$a]->id,"buyer_id"=>$request->user()->id])->get();
            $p_information["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $p_information["sold"]=count($sold);


            array_push($products,$p_information);

        }

        return Response::json([
            "errpr"=>false,
            "data"=>$products
        ]);


    }

}
