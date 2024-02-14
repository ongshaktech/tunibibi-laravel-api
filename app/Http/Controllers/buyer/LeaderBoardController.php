<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class LeaderBoardController extends Controller
{
    function LeaderBoard(Request $request){


        $data=DB::table("buyer_refer_earnings")->join("buyers","buyer_refer_earnings.refer_user_type","=","buyers.id")->orderBy("coins","desc")->get();

        $rank_details = array();
        $rank=0;

        array_push($rank_details,[
            "buyer_id"=>1,
            "name"=>"SS",
            "rank"=>1,
            "image"=>"http://api-laravel.tunibibi.com/storage/image/64fab0b0db6f0.png",
            "amount"=>200
        ]);
        array_push($rank_details,[
            "buyer_id"=>13,
            "name"=>"SS",
            "rank"=>1,
            "image"=>"http://api-laravel.tunibibi.com/storage/image/64fab0b0db6f0.png",
            "amount"=>200
        ]);
        array_push($rank_details,[
            "buyer_id"=>15,
            "name"=>"SS",
            "rank"=>1,
            "image"=>"http://api-laravel.tunibibi.com/storage/image/64fab0b0db6f0.png",
            "amount"=>200
        ]);
        array_push($rank_details,[
            "buyer_id"=>18,
            "name"=>"SS",
            "rank"=>1,
            "image"=>"http://api-laravel.tunibibi.com/storage/image/64fab0b0db6f0.png",
            "amount"=>200
        ]);
        foreach ($data as $value){
            $rank++;
            array_push($rank_details,[
                "buyer_id"=>$value->id,
                "name"=>$value->name,
                "rank"=>$rank,
                "image"=>config("app.url")."storage/image/".$value->image,
                "amount"=>200]);
        }

        return Response::json([
            "error" => false,
            "ranks" => $rank_details
        ]);


    }
}
