<?php

namespace App\Http\Controllers;

use App\Models\BuyerReferEarning;
use App\Models\SellerReferEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BuyerReferEarningController extends Controller
{
    function MyReferEarning(Request $request)
    {

        $amount = SellerReferEarning::where(["seller_id" => $request->user()->id])->sum("coins");
        $ranks = SellerReferEarning::all();

        $in_users = array();

        $rank_details = array();

        for ($a = 0; $a < count($ranks); $a++) {
            $temp_data = [];
            if (in_array($ranks[$a]->id, $in_users)) {


                $temp_data["id"] = $ranks[$a]->id;
                $coins = SellerReferEarning::where("seller_id", $ranks[$a]->id)->sum("coins");
                $seller_info = \App\Models\Seller::where("id", $ranks[$a]->id)->first();
                $temp_data["shop_name"] = $seller_info->shop_name;
                $temp_data["logo"] = $seller_info->logo;
                $temp_data["coins"] = $coins;
                $temp_data["rank"] = "10";


                array_push($rank_details, $temp_data);

                array_push($in_users, $ranks[$a]->id);
            }


        }

        return Response::json([
            "error" => false,
            "my_earning_info" => [
                [
                    "amount" => $amount,
                    "rank" => 1,
                ]
            ],
            "ranks" => $ranks
        ]);

    }

    function Recharge(Request $request){
        $coins = SellerReferEarning::where("seller_id",$request->user()->id)->sum("coins");
        if($coins>$request->amount){
            return Response()->json(["error"=>true,"msg"=>"Successfully Recharge"]);
        }else{
        return Response()->json(["error"=>true,"msg"=>"You have not enough coins"]);
        }

    }

    function MyRefers(Request $request){

        $ranks = SellerReferEarning::where("seller_id",$request->user()->id)->get();

        $in_users = array();

        $rank_details = array();

        for ($a = 0; $a < count($ranks); $a++) {
            $temp_data = [];
            if (in_array($ranks[$a]->id, $in_users)) {


                $temp_data["id"] = $ranks[$a]->id;
                $coins = SellerReferEarning::where("seller_id", $ranks[$a]->id)->sum("coins");
                $seller_info = \App\Models\Seller::where("id", $ranks[$a]->id)->first();
                $temp_data["shop_name"] = $seller_info->shop_name;
                $temp_data["logo"] = $seller_info->logo;
                $temp_data["coins"] = $coins;
                $temp_data["rank"] = "10";


                array_push($rank_details, $temp_data);

                array_push($in_users, $ranks[$a]->id);
            }


        }

        return Response::json([
            "error" => false,
            "data" => $ranks
        ]);


    }
}
