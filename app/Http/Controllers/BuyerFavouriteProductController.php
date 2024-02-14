<?php

namespace App\Http\Controllers;

use App\Models\buyer_favourite_name;
use App\Models\buyer_favourite_product;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\WholesalePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BuyerFavouriteProductController extends Controller
{



    function CatagoryIndex(Request $request){

        $catagory=buyer_favourite_name::where(["buyer_id"=>$request->user()->id])->get();

        $result_data=array();
        foreach ($catagory as $item) {

                array_push($result_data,[
                    "id"=>$item->id,
                    "name"=>$item->name
                ]);
                }
        return Response::json([
            "error"=>false,
            "data"=>$result_data
        ]);
    }
    function CatagoryCreate(Request $request){

        $result=buyer_favourite_name::create(["buyer_id"=>$request->user()->id,"name"=>$request->name]);
        if($result!=null){
            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Added On Favourite List"
            ]);

        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Opps!Something Wrong!",

            ]);
        }

    }


    function Index(Request $request){

        $catagory=buyer_favourite_name::where(["buyer_id"=>$request->user()->id])->get();

        $result_data=array();
        foreach ($catagory as $item) {

            $buyer_favourite_products=buyer_favourite_product::where(['buyer_favourite_names_id'=>$item->id])->get();


            if(count($buyer_favourite_products)>0){
                foreach ($buyer_favourite_products as $favourite){
                    $featured_products_fetch=Product::where(["id"=>$favourite->product_id])->get();
                    $products=array();


                    for($a=0; $a<count($featured_products_fetch); $a++){
                        $p_information=[];
                        $p_information["id"]=$featured_products_fetch[$a]->id;
                        $p_information["product_name"]=$featured_products_fetch[$a]->product_name;

                        $images=ProductImage::where("product_id",$featured_products_fetch[$a]->id)->first();
                        $price=WholesalePrice::where("product_id",$featured_products_fetch[$a]->id)->first();
                        $sold=Order::where("product_id","like","%".$featured_products_fetch[$a]->id."%")->get();


                        if($images!=null){
                            $p_information["image"]=strval(config("app.url")."storage/products/".$images->img);

                        }
                        if($price!=null){
                            $p_information["price"]=$price->amount;

                        }



                        $today=date("Y-m-d");

                        $disc_price=DB::table("super_deals")->whereDate("to",">=",$today)->where("product_id",$featured_products_fetch[$a]->id)->first();

                        if($disc_price!=null){
                            $disc_info=json_decode($disc_price->wholesale_price_id)[0]->amount;
                            $p_information["disc_price"]=$disc_info;
                            $p_information["disc_percent"]=20;
                        }else{
                            $p_information["disc_price"]=0;
                            $p_information["disc_percent"]=0;
                        }



                        $buyer_favourite_products=buyer_favourite_product::where(['product_id'=>$featured_products_fetch[$a]->id,"buyer_id"=>$request->user()->id])->get();
                        $p_information["is_favourite"]=count($buyer_favourite_products)>0?true:false;

                        $p_information["sold"]=count($sold);
                        array_push($products,$p_information);

                    }

                    $is_in_list=false;
                    $list_pos=0;
                    for($a=0; $a<count($result_data); $a++){
                        if($result_data[$a]["favourite_list_name"]==$item->name){
                            $is_in_list=true;
                            $list_pos=$a;
                            break;
                        }
                    }

                    if($is_in_list){
                        array_push($result_data[$list_pos]["products"],$products[0]);
                    }else{
                        $result_format=["favourite_list_name"=>$item->name,"products"=>$products];
                        array_push($result_data,$result_format);
                    }




                }
            }


        }
        return Response::json([
            "error"=>false,
            "data"=>$result_data
        ]);
    }
    function Create(Request $request){

        try {
            $check_already_exists=buyer_favourite_product::where(["product_id"=>$request->product_id,"buyer_favourite_names_id"=>$request->list_id,"buyer_id"=>$request->user()->id])->get();
            if(count($check_already_exists)>0){
                return Response::json([
                    "error"=>true,
                    "msg"=>"Already Product Added"
                ]);

            }else{
                $result=buyer_favourite_product::create(["product_id"=>$request->product_id,"buyer_favourite_names_id"=>$request->list_id,"buyer_id"=>$request->user()->id]);

                if($result!=null){
                    return Response::json([
                        "error"=>false,
                        "msg"=>"Successfully Added On Favourite List"
                    ]);
                }else{
                    return Response::json([
                        "error"=>true,
                        "msg"=>"Opps!Something Wrong!"
                    ]);
                }
            }

        }catch (\Exception $exception){
            return Response::json([
                "error"=>true,
                "msg"=>"Opps!Something Wrong!"
            ]);
        }



    }
}
