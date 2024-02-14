<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\Storage;

class SellerHomeController extends Controller
{


   function ShopInfo(Request $request){

    $shop_info=Seller::where(["sellers.id"=>$request->user()->id])->join("business_types","sellers.business_type_id","business_types.id")->first();

    if($shop_info!=null){

        return response()->json([
            "error"=>false,
            "data"=>[
                "phone"=>$shop_info->phone,
                "shop_name"=> $shop_info->shop_name,
                "business_type_id"=> BusinessType::where("id",$shop_info->business_type_id)->get(),
                "address"=>$shop_info->address,
                "slug"=>$shop_info->slug,
                "email"=>$shop_info->email,
                "logo"=>config("app.url")."storage/logo/".$shop_info->logo
            ]
        ]);

    }else{
        return response()->json([
            "error"=>true,
            "msg"=>"Not Found!"
        ]);
    }
   }


    function Home(){





        return response()->json([
            "error"=>false,
            "data"=>[
                "orders"=> 0,
                "total_sales"=> 0,
                "store_view"=> 0,
                "product_view"=> 0
            ]
        ],);
    }

}
