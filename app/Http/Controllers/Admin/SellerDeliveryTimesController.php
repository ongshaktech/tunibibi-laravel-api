<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SellerDeliveryTimesController extends Controller
{



    function Index(){
        $data=DeliveryTimes::all();

        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function Store(Request $request){
        DeliveryTimes::create([
            "times"=>$request->times,
            "minutes"=>$request->minutes,
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Added"
        ]);
    }

    function Update($id,Request $request){
        DeliveryTimes::where("id",$id)->update([
            "times"=>$request->times,
            "minutes"=>$request->minutes,
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Update Successfully"
        ]);
    }
    function Delete($id){
        DeliveryTimes::where("id",$id)->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }
}
