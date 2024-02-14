<?php

namespace App\Http\Controllers;

use App\Models\SellerRechargeRequest;
use App\Models\SellerReferEarning;
use App\Models\SellerReferPolicy;
use App\Models\Voucher;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerReferEarningController extends Controller
{

    function LeaderBoard(Request $request){


        $data=DB::table("seller_refer_earnings")->join("sellers","seller_refer_earnings.refered_seller_id","=","sellers.id")->orderBy("coins","desc")->get();


        $rank_details = array();
        $rank=0;
        foreach ($data as $value){
            $rank++;
            array_push($rank_details,[
                    "seller_id"=>$value->seller_id,
                    "rank"=>$rank,
                    "shop_name"=>$value->shop_name,
                    "logo"=>config("app.url")."storage/logo/".$value->logo,
                    "amount"=>200]);
        }

                return Response::json([
            "error" => false,
            "ranks" => $rank_details
        ]);




    }

    function MyRank(Request $request){
        $data_info=array();
        $seller_comission_amount=0;
        $seller_buyer_comission_amount=0;
        $seller_comission=DB::table("seller_refer_comission")->where("country",$request->user()->country)->first();
        $seller_buyer_comission=DB::table("seller_buyer_refer_comission")->where("country",$request->user()->country)->first();
        $exchage=DB::table("seller_refer_coin_exchange")->where("country",$request->user()->country)->get();
        $coin_type=DB::table("seller_coin_type")->where("country",$request->user()->country)->first()->coin_name;

        if($seller_comission!=null){
            $seller_comission_amount=$seller_comission->amount;
        }
        if($seller_buyer_comission!=null){
            $seller_buyer_comission_amount=$seller_buyer_comission->amount;
        }


        $data=DB::table("seller_refer_earnings")->join("sellers","seller_refer_earnings.refered_seller_id","=","sellers.id")->orderBy("coins","desc")->get();

        $my_rank=0;
        $my_coins=0;

        foreach ($data as $value){
            $my_rank++;
            if($value->refered_seller_id==$request->user()->id){
                $my_coins+=$value->coins;
                break;
            }
        }


        array_push($data_info,["rank"=>$my_rank,"amount"=>$my_coins,"amount_type"=>$coin_type,"seller_refer_comission"=>$seller_comission_amount,"buyer_refer_comission"=>$seller_buyer_comission_amount,"exchange"=>$exchage]);

        return Response::json([
            "error"=>false,
            "data"=>$data_info
        ]);
    }
    function MyRankBuyer(Request $request){
        $data_info=array();
        $seller_comission_amount=0;
        $seller_buyer_comission_amount=0;
        $seller_comission=DB::table("seller_refer_comission")->where("country",$request->user()->country)->first();
        $seller_buyer_comission=DB::table("seller_buyer_refer_comission")->where("country",$request->user()->country)->first();
        $exchage=DB::table("seller_refer_coin_exchange")->where("country",$request->user()->country)->get();
        $coin_type=DB::table("seller_coin_type")->where("country",$request->user()->country)->first()->coin_name;

        if($seller_comission!=null){
            $seller_comission_amount=$seller_comission->amount;
        }
        if($seller_buyer_comission!=null){
            $seller_buyer_comission_amount=$seller_buyer_comission->amount;
        }


        $data=DB::table("buyer_refer_earnings")->join("buyers","buyer_refer_earnings.refered_buyer_id","=","buyers.id")->orderBy("coins","desc")->get();

        $my_rank=0;
        $my_coins=0;

        foreach ($data as $value){
            $my_rank++;
            if($value->refered_buyer_id==$request->user()->id){
                $my_coins+=$value->coins;
                break;
            }
        }


        array_push($data_info,["rank"=>$my_rank,"amount"=>$my_coins,"amount_type"=>$coin_type,"seller_refer_comission"=>$seller_comission_amount,"buyer_refer_comission"=>$seller_buyer_comission_amount,"exchange"=>$exchage]);

        return Response::json([
            "error"=>false,
            "data"=>$data_info
        ]);
    }

    function ClaimPoint(Request $request){
        $data=DB::table("buyer_refer_earnings")->join("buyers","buyer_refer_earnings.refered_buyer_id","=","buyers.id")->orderBy("coins","desc")->get();

        $my_rank=0;
        $my_coins=0;

        foreach ($data as $value){
            $my_rank++;
            if($value->refered_buyer_id==$request->user()->id){
                $my_coins+=$value->coins;
                break;
            }
        }
        $exp_date=date('Y-m-d',strtotime("+60 days"));
       $voucher_data=Voucher::create([
            "user_id"=>$request->user()->id,
            "user_type"=>"buyer",
            "voucher_code"=>Str::random(6),
            "min_amount"=>100,
            "amount"=>$my_coins,
            "expire_date"=>$exp_date,
        ]);

       return Response::json([
           "error"=>false,
           "data"=>[
               "id"=>$voucher_data->id,
               "voucher_code"=>$voucher_data->voucher_code,
               "min_amount"=>$voucher_data->min_amount,
               "amount"=>$voucher_data->amount,
               "expire_date"=>$voucher_data->expire_date,
           ]
       ]);

    }
function ReferPolicy(){
    $data_info=SellerReferPolicy::select("policy")->get();

    return Response::json([
        "error"=>false,
        "data"=>$data_info
    ]);
}

function Recharge(Request $request){
    $data_info=SellerRechargeRequest::create(["country_name"=>$request->country_name,"code"=>$request->code,"mobile_no"=>$request->mobile_no,"operator"=>$request->operator,"amount"=>$request->amount]);

    return Response::json([
        "error"=>false,
        "msg"=>"Your Request Saved Successfully"
    ]);
}
    function RechargeData(Request $request){
        $data_info=SellerRechargeRequest::all();

        return Response::json([
            "error"=>false,
            "data"=>$data_info
        ]);
    }





function Countrys(){

    $data=DB::table("country")->get();
        return Response::json([
        "error"=>false,
        "data"=>$data
    ]);

}

function Operators($id){

        return Response::json([
        "error"=>false,
        "data"=>["Banglalink","Grameenphone","Robi","Airtel"]
    ]);

}



}
