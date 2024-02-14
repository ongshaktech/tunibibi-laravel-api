<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ShopOnline;
class ShopOnlineConteroller extends Controller
{

    function CheckStatus(Request $request){
       $info= \App\Models\Seller::where(["id"=>$request->user()->id])->first();
       $is_active=false;

       if($info->is_online==1){
           $is_active=true;
       }

        return response()->json([
            "error"=>false,
            "is_active"=>$is_active
        ]);
    }
    function GoOnline(Request $request){



        $status=ShopOnline::create([
            "shop_id"=>$request->user()->id,
            "from_time"=>$request->time,
            "from_date"=>$request->date,
        ]);

        \App\Models\Seller::where(["id"=>$request->user()->id])->update(["is_online"=>1]);
        if($status!=null){
            return response()->json([
                "error"=>false,
                "msg"=>"Successfully Online Record Saved"
            ]);
        }else{
            return response()->json([
                "error"=>true,
                "msg"=>"Opps! Something Wrong!",
                "status"=>$status
            ]);
        }

    }

    function GoOffline(Request $request){

        $status=ShopOnline::where(["shop_id"=>$request->user()->id])->update([
            "to_time"=>$request->time,
            "to_date"=>$request->date,
        ]);
        \App\Models\Seller::where(["id"=>$request->user()->id])->update(["is_online"=>0]);
        return response()->json([
            "error"=>false,
            "msg"=>"Now You Are Offline"
        ]);
    }
}
