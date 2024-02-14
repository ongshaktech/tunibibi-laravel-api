<?php

namespace App\Http\Controllers;

use App\Models\SellerFollowers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerFlowersController extends Controller
{
    function Following($id,Request $request){

        SellerFollowers::insert(["seller_id"=>$id,"buyer_id"=>$request->user()->id]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Flowing"
        ]);

    }

    function Unfollowing($id,Request $request){

        SellerFollowers::where(["seller_id"=>$id,"buyer_id"=>$request->user()->id])->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Unfollow"
        ]);

    }
}
