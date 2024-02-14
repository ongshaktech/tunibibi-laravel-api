<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BuyerProductCountrySelectController extends Controller
{

    function Index(Request $request){

        return Response::json([
            "error"=>false,
            "selected_country"=>$request->user()->search_country
        ]);

    }

    function Update(Request $request){
        Buyer::where(["id"=>$request->user()->id])->update([
            "search_country"=>$request->country
        ]);
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

}
