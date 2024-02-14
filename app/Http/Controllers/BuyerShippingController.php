<?php

namespace App\Http\Controllers;

use App\Models\buyer_shipping;
use App\Models\ShippingPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BuyerShippingController extends Controller
{

    function index(Request $request){
        $data=buyer_shipping::where("buyer_id",$request->user()->id,)->first();

        if($data!=null){
           $data=ShippingPackages::where('id',$data->shipping_package_id)->first();
            return Response::json([
                "error"=>false,
                "data"=>[
                    "id"=>$data->id,
                    "from_country"=>$data->from_country,
                    "to_country"=>$data->to_country,
                    "amount"=>$data->amount,
                    "days"=>$data->days,
                    "shipping_type"=>$data->shipping_type,
                ]
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"NO Shipping Address Found!"
            ]);
        }

    }

    function store($id,Request $request){

        buyer_shipping::where("buyer_id",$request->user()->id,)->delete();

        buyer_shipping::create([
            "buyer_id"=>$request->user()->id,
            "shipping_package_id"=>$id
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Stored"
        ]);

    }
}
