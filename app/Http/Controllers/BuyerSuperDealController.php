<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\buyer_favourite_product;
use App\Models\Catagory;
use App\Models\featured_shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductVarient;
use App\Models\SellerFollowers;
use App\Models\SubCatagory;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use function Sodium\add;

class BuyerSuperDealController extends Controller
{
    function Index(Request $request){

        $today=date("Y-m-d");

        $data=DB::table("super_deals")->whereDate("to",">=",$today)->get();

        $new_data=array();

        foreach ($data as $value){
            $images=ProductImage::where("product_id",$value->product_id)->first();

            if($images!=null){
                $images=$images->img;
            }else{
                $images="";
            }

            $today=date("Y-m-d");

            $disc_prices=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$value->product_id)->first();

            $disc_price=0;
            $disc_percent=0;


            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$value->product_id,"buyer_id"=>$request->user()->id])->get();
            $sold=Order::where("product_id","like","%".$value->product_id."%")->get();

            $product_info=Product::where(["id"=>$value->product_id])->first();
            if($data!=null){
                $disc_info=json_decode($disc_prices->wholesale_price_id)[0]->amount;
                $disc_price=$disc_info;
                $disc_percent=20;
            }else{
                $disc_price=0;
                $disc_percent=0;
            }




            array_push($new_data,[
                "id"=>$value->id,
                "shop_id"=>(int)$product_info->seller_id,
                "product_name"=>$product_info->product_name,
                "product_image"=>config("app.url")."storage/products/".$images,
                "details"=>json_decode($value->wholesale_price_id),
                "is_favourite"=>count($buyer_favourite_products)>0?true:false,
                "sold"=>count($sold),
                "price"=>json_decode($value->wholesale_price_id)[0]->amount,
                "disc_price"=>$disc_price,
                "disc_percent"=>$disc_percent,
                "end_date"=>$value->to,
            ]);
        }
        return Response::json([
            "error"=>false,
            "data"=>$new_data
        ]);

    }

    function Show($id,Request $request){

        $data_super=DB::table("super_deals")->where("id","=",$id)->first();

        $products=DB::table("products")->where(["id"=>$data_super->product_id])->get();

        $products_info=array();


        for($a=0; $a<count($products); $a++){
            $p_info=[];
            $p_info["id"]=$products[$a]->id;
            $p_info["shop_id"]=(int)$products[$a]->seller_id;
            $p_info["product_name"]=$products[$a]->product_name;



            $p_info["product_details"]=$products[$a]->product_details;

            $p_info["total_order"]=count(Order::where(["product_id"=>$data_super->product_id])->get());

            $p_info["wholesale_price"]=json_decode($data_super->wholesale_price_id);

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


            $last_buy=Order::where("product_id","like","%".$data_super->product_id."%")->latest()->first();

            if($last_buy!=null){

                $l_buyer_info=Buyer::where(["id"=>$last_buy->buyer_id])->first();
                $get_flag=DB::table("country")->where(["name"=>$l_buyer_info->country])->first()->flag;
                $p_info["last_buy"]=[
                    "name"=>$l_buyer_info->name,
                    "country"=>config("app.url")."storage/flags/".$get_flag
                ];
            }else{
                $p_info["last_buy"]=[
                    "name"=>null,
                    "country"=>null
                ];
            }




            $today=date("Y-m-d");

            $disc_prices=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$value->product_id)->first();

            $disc_price=0;
            $disc_percent=0;


            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$value->product_id,"buyer_id"=>$request->user()->id])->get();
            $sold=Order::where("product_id","like","%".$value->product_id."%")->get();

            $product_info=Product::where(["id"=>$value->product_id])->first();
            if($data!=null){
                $disc_info=json_decode($disc_prices->wholesale_price_id)[0]->amount;
                $disc_price=$disc_info;
                $disc_percent=20;
            }else{
                $disc_price=0;
                $disc_percent=0;
            }

            $price=WholesalePrice::where("product_id",$value->product_id)->first();

            if($price!=null){
                $price=$price->amount;

            }else{
                $price=0;
            }

            $p_info["in_stock"]=$products[$a]->stock;
            $p_info["price"]=$price;
            $p_info["disc_price"]=$disc_price;
            $p_info["disc_percent"]=$disc_percent;
            $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $p_info["sold"]=count($sold);
            $p_info["buy_together"]=true;

            $review_fetch=ProductReview::where(["product_id"=>$data_super->product_id])->get();
            $reviews=array();
            foreach($review_fetch as $rev){

                //Buyer Info
                $buyer=Buyer::where(["id"=>$rev["user_id"]])->first();
                $get_flag=DB::table("country")->where(["name"=>$buyer->country])->first()->flag;

                if($buyer!=null){
                    $new_value=[
                        "user_name"=>$buyer->name,
                        "country"=> config("app.url")."storage/flags/".$get_flag,
                        "date"=>$rev->created_at,
                        "rating"=>$rev->rating,
                        "comment"=>$rev->comment,
                    ];
                    array_push($reviews,$new_value);
                }
            }


            $p_info["review"]=$reviews;
            array_push($products_info,$p_info);

        }



        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);

    }


    function  Reviews($id){
        $review_fetch=ProductReview::where(["product_id"=>$id])->get();
        $reviews=array();
        foreach($review_fetch as $rev){

            //Buyer Info
            $buyer=Buyer::where(["id"=>$rev["user_id"]])->first();

            $new_value=[
                "user_name"=>$buyer->name,
                "country"=>$buyer->country,
                "date"=>$rev->created_at,
                "rating"=>$rev->rating,
                "comment"=>$rev->comment,
            ];
            array_push($reviews,$new_value);
        }

        return Response::json([
            "error"=>false,
            "data"=>$reviews
        ]);
    }

    function ShopInfo($id,Request $request){


        $new_data=[];
        $data=\App\Models\Seller::where("id",$id)->first();

        $new_data["positive"]=20;
        $new_data["items"]=Product::where("seller_id",$id)->count();
        $new_data["follower"]=SellerFollowers::where("seller_id",$id)->count();
        $flag_url=DB::table("country")->where("name",$data->country)->first()->flag;
        $new_data["country"]=config("app.url")."storage/flag/".$flag_url;
        $new_data["shop_name"]=$data->shop_name;
        $new_data["logo"]=config("app.url")."storage/business/".$data->image;
        //Featured Products



        $featured_products=array();
        $datas=featured_shop::where("shop_id",$id)->get();

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



        $products_fetch=Product::where("Seller_id",$id)->get();


        $products=array();

        for($a=0; $a<count($products_fetch); $a++){
            $p_information=[];
            $p_information["id"]=$products_fetch[$a]->id;
            $p_information["shop_id"]=$products_fetch[$a]->seller_id;
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


            $today=date("Y-m-d");

            $disc_price=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$products_fetch[$a]->id)->first();

            if($disc_price!=null){
                $disc_info=json_decode($disc_price->wholesale_price_id)[0]->amount;
                $p_information["disc_price"]=$disc_info;
                $p_information["disc_percent"]=20;
            }else{
                $p_information["disc_price"]=0;
                $p_information["disc_percent"]=0;
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

            $quantity_array=json_decode($last_buy->quantity);
            $quantity=$quantity_array;

            $new_data["last_buy_quantity"]=$quantity;

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

    function ProductDetails($id,Request $request){
        $products=DB::table("products")->where(["id"=>$id])->get();

        $products_info=array();


        for($a=0; $a<count($products); $a++){
            $p_info=[];

            $p_info["id"]=$products[$a]->id;
            $p_info["seller_id"]=$products->first()->seller_id;
            $p_info["product_name"]=$products[$a]->product_name;

            $p_info["product_details"]=$products[$a]->product_details;

            $p_info["total_order"]=count(Order::where(["product_id"=>$id])->get());

            $wholesale_price=WholesalePrice::where("product_id",$products[$a]->id)->get();
            $p_info["wholesale_price"]=$wholesale_price;


            $today=date("Y-m-d");

            $disc_price=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$id)->first();
            $price=WholesalePrice::where("product_id",$id)->first();

            if($price!=null) {
                $p_info["price"] = $price->amount;
            }else{
                $p_info["price"] = 0;
            }
            if($disc_price!=null){
                $disc_info=json_decode($disc_price->wholesale_price_id)[0]->amount;
                $p_info["disc_price"]=$disc_info;
                $p_info["disc_percent"]=20;
            }else{
                $p_info["disc_price"]=0;
                $p_info["disc_percent"]=0;
            }



            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$id,"buyer_id"=>$request->user()->id])->get();
            $p_info["is_favourite"]=count($buyer_favourite_products)>0?true:false;
            $sold=Order::where("product_id","like","%".$id."%")->get();

            $p_info["sold"]=count($sold);
            $p_info["buy_together"]=true;


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


            $last_buy=Order::where("product_id","like","%".$id."%")->latest()->first();

            if($last_buy!=null){
                $l_buyer_info=Buyer::where(["id"=>$last_buy->buyer_id])->first();
                $get_flag=DB::table("country")->where(["name"=>$l_buyer_info->country])->first()->flag;
                $p_info["last_buy"]=[
                    "name"=>$l_buyer_info->name,
                    "country"=>config("app.url")."storage/flags/".$get_flag
                ];

            }else{
                $p_info["last_buy"]=[
                    "name"=>null,
                    "country"=>null
                ];;
            }

            $p_info["in_stock"]=$products[$a]->stock;

            $review_fetch=ProductReview::where(["product_id"=>$id])->get();
            $reviews=array();
            foreach($review_fetch as $rev){

                //Buyer Info
                $buyer=Buyer::where(["id"=>$rev["user_id"]])->first();

                $get_flag=DB::table("country")->where(["name"=>$buyer->country])->first()->flag;

                if($buyer!=null){
                    $new_value=[
                        "user_name"=>$buyer->name,
                        "country"=> config("app.url")."storage/flags/".$get_flag,
                        "date"=>$rev->created_at,
                        "rating"=>$rev->rating,
                        "comment"=>$rev->comment,
                    ];
                    array_push($reviews,$new_value);
                }

            }


            $p_info["review"]=$reviews;
            array_push($products_info,$p_info);

        }



        return Response::json([
            "error"=>false,
            "data"=>$products_info
        ]);
    }


    function CategoryWithDeals(Request $request){

        $today=date("Y-m-d");

        $data=DB::table("super_deals")->whereDate("to",">=",$today)->get();

        $category_id=array();
        foreach ($data as $value){
            $images=ProductImage::where("product_id",$value->product_id)->first()->img??"";

            $today=date("Y-m-d");

            $disc_prices=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$value->product_id)->first();

            $disc_price=0;
            $disc_percent=0;


            $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$value->product_id,"buyer_id"=>$request->user()->id])->get();
            $sold=Order::where("product_id","like","%".$value->product_id."%")->get();

            $product_info=Product::where(["id"=>$value->product_id])->first();
            if($data!=null){
                $disc_info=json_decode($disc_prices->wholesale_price_id)[0]->amount;
                $disc_price=$disc_info;
                $disc_percent=20;
            }else{
                $disc_price=0;
                $disc_percent=0;
            }


            $Catagory_info=Catagory::where("id",$product_info->catagory_id)->first();

            $is_fina_catagory=false;
            forEach($category_id as $category_datas){
                if($category_datas["catagory_id"]==$product_info->catagory_id){
                    $is_fina_catagory=true;
                }
            }
            if($is_fina_catagory===false){
                $a_data=[];
                array_push($a_data,[
                    "id"=>$value->id,
                    "shop_id"=>(int)$product_info->seller_id,
                    "product_name"=>$product_info->product_name,
                    "product_image"=>config("app.url")."storage/products/".$images,
                    "details"=>json_decode($value->wholesale_price_id),
                    "is_favourite"=>count($buyer_favourite_products)>0?true:false,
                    "sold"=>count($sold),
                    "price"=>json_decode($value->wholesale_price_id)[0]->amount,
                    "disc_price"=>$disc_price,
                    "disc_percent"=>$disc_percent,
                    "end_date"=>$value->to,

                ]);

                array_push($category_id,[
                    "catagory_id"=>$Catagory_info->id,
                    "catagory_name"=>$Catagory_info->catagory_name,
                    "data"=>$a_data
                ]);

            }else{

                for ($a=0; $a<count($category_id); $a++){
                    if($category_id[$a]["catagory_id"]==$product_info->catagory_id){

                        $a_data=[];
                        array_push($category_id[$a]["data"],[
                            "id"=>$value->id,
                            "shop_id"=>(int)$product_info->seller_id,
                            "product_name"=>$product_info->product_name,
                            "product_image"=>config("app.url")."storage/products/".$images,
                            "details"=>json_decode($value->wholesale_price_id),
                            "is_favourite"=>count($buyer_favourite_products)>0?true:false,
                            "sold"=>count($sold),
                            "price"=>json_decode($value->wholesale_price_id)[0]->amount,
                            "disc_price"=>$disc_price,
                            "disc_percent"=>$disc_percent,
                            "end_date"=>$value->to,

                        ]);

                    }
                }
            }

//            array_push($new_data,[
//                "id"=>$value->id,
//                "shop_id"=>(int)$product_info->seller_id,
//                "product_name"=>$product_info->product_name,
//                "product_image"=>config("app.url")."storage/products/".$images,
//                "details"=>json_decode($value->wholesale_price_id),
//                "is_favourite"=>count($buyer_favourite_products)>0?true:false,
//                "sold"=>count($sold),
//                "price"=>json_decode($value->wholesale_price_id)[0]->amount,
//                "disc_price"=>$disc_price,
//                "disc_percent"=>$disc_percent,
//                "end_date"=>$value->to,
//            ]);
        }

        return Response::json([
            "error"=>false,
            "data"=>$category_id
        ]);

    }

}
