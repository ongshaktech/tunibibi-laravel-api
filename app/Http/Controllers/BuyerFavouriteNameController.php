<?php

namespace App\Http\Controllers;

use App\Models\buyer_favourite_name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BuyerFavouriteNameController extends Controller
{

    function Index(Request $request){


        return "OK";
        $data=buyer_favourite_name::where(["buyer_id"=>$request->user()->id])->get();

        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function paymCreate(Request $request){

       $status= buyer_favourite_name::create(["name"=>$request->name,"buyer_id"=>$request->user()->id]);

       if($status!=null){
           return Response::json([
               "error"=>false,
               "message"=>"Successfully Created New Favourite List"
           ]);
       }else{
           return Response::json([
               "error"=>true,
               "message"=>"Opps!Something Wrong"
           ]);
       }

    }

    function Show($id){

    }

    function Update($id){

    }
    function Delete($id){

    }
}
