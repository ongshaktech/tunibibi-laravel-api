<?php

namespace App\Http\Controllers;

use App\Models\buyer_shipping_address;
use App\Models\city_delivery_charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CityDeliveryChargeController extends Controller
{
    function Show(Request $request){
        $data=city_delivery_charge::where("country_name",$request->country)->get();
        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function ShowChargeByAddressID(Request $request){
        $data=buyer_shipping_address::where(["id"=>$request->address_id])->first();

       $charges= city_delivery_charge::where(["country_name"=>$data->country,"city_name"=>$data->city])->first();

       return Response::json([
           "error"=>false,
           "amount"=>$charges->amount
       ]);
    }

}
