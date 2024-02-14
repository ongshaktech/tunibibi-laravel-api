<?php

namespace App\Http\Controllers\Admin;
use App\Models\Buyer;
use App\Models\Catagory;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\Seller;
use App\Models\SubCatagory;
use App\Models\WholesalePrice;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    function index(){

        $total_seller=Seller::count();
        $total_buyer=Buyer::count();
        $total_category=Catagory::count();
        $total_orders=Order::count();


        $total_published_products=Product::where("is_active",1)->count();
        $total_sellers_products=Product::count();


        $total_sellers=Seller::count();
        $total_approved_sellers=Seller::where("is_active",1)->count();
        $total_pending_sellers=Seller::where("is_active",0)->count();

        $total_catagory=Catagory::all();

        $category_names=array();
        $category_names_products=array();
        foreach ($total_catagory as $category){
            array_push($category_names,$category->catagory_name);
            $product_count=Product::where("catagory_id",$category->id)->count();
            array_push($category_names_products,$product_count);
        }


        $top_products_data=DB::table('orders')
            ->select('product_id', DB::raw('COUNT(*) as `count`'))
            ->groupBy('product_id')
            ->orderBy("count","desc")
            ->get();

        $top_products=array();

        foreach ($top_products_data as $product){

            $products=Product::where("id",$product->product_id)->first();

            $p_info=[];
            $p_info["id"]=$products->id;
            $p_info["product_name"]=$products->product_name;

            $p_info["product_details"]=$products->product_details;

            $product_varient=ProductVarient::where("product_id",$products->id)->get();

            $data=array();

            foreach ($product_varient as $value){
                array_push($data,["id"=>$value->id,"name"=>$value->name,"color"=>strval(config("app.url")."storage/varients/".$value->color),"varients"=>json_decode($value->varients)]);
            }
            $p_info["product_varient"]=$data;



            $images=ProductImage::where("product_id",$products->id)->get();

            $data=array();

            foreach ($images as $value){
                array_push($data,["id"=>$value->id,"img"=>strval(config("app.url")."storage/products/".$value->img)]);
            }
            $p_info["images"]=$data;


            array_push($top_products,$p_info);

        }



        return Response::json([
            "error"=>false,
            "analysis"=>[
                "total_seller"=>$total_seller,
                "total_buyer"=>$total_buyer,
                "total_category"=>$total_category,
                "total_orders"=>$total_orders,
            ],
            "products"=>[
                "labels"=>["Total Published Products","Total Sellers Product"],
                "datasets"=>[[
                    "data"=>[$total_published_products,$total_sellers_products]
                ]]
            ],
            "sellers"=>[
                "labels"=>["Total Sellers","Total Approved Sellers","Total Pending Seller"],
                "datasets"=>[[
                    "data"=>[$total_sellers,$total_approved_sellers,$total_pending_sellers]
                ]]

            ],
            "category_wise_products"=>[
                "labels"=>$category_names,
                "datasets"=>[[
                    "data"=>$category_names_products
                ]]

            ],
            "top_products"=>$top_products
        ]);
    }
}
