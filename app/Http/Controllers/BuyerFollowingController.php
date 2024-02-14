<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SellerFollowers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BuyerFollowingController extends Controller
{
    function Index(Request $request){

        $followings=SellerFollowers::where("buyer_id",$request->user()->id)->get();
        $sellers=array();

       foreach ($followings as $value){
           $data=\App\Models\Seller::where("id",$value->seller_id)->first();
           $new_data["id"]=$data->id;
           $new_data["name"]=$data->shop_name;
           $new_data["logo"]=config("app.url")."storage/logo/".$data->logo;
           $new_data["postive"]=20;
           $new_data["items"]=Product::where("seller_id",$value->seller_id)->count();
           $new_data["follower"]=SellerFollowers::where("seller_id",$value->seller_id)->count();
           $flag_url=DB::table("country")->where("name",$data->country)->first()->flag;
           $new_data["country"]=config("app.url")."storage/flag/".$flag_url;

           array_push($sellers,$new_data);

       }


       return Response::json([
           "error"=>false,
           "data"=>$sellers
       ]);

    }
}
