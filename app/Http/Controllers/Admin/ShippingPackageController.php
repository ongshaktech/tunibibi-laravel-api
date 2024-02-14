<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ShippingPackageController extends Controller
{

    function Index(){

        $all=ShippingPackages::all();

        $formated_data=array();

        foreach ($all as $value){

            array_push($formated_data,[
                "id"=>$value->id,
                "from_country"=>$value->from_country,
                "to_country"=>$value->to_country,
                "days"=>$value->days,
                "shipping_type"=>$value->shipping_type,
                "unit_types"=>json_decode($value->unit_types)
            ]);

        }

        return Response::json([
            "error"=>false,
            "data"=>$formated_data
        ]);

    }



    function Store(Request $request){

        ShippingPackages::create([
            "from_country"=>$request->from_country,
            "to_country"=>$request->to_country,
            "amount"=>0,
            "days"=>$request->days,
            "shipping_type"=>$request->shipping_type,
            "unit_types"=>json_encode($request->unit_types)
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Store"
        ]);

    }
    function Update($id,Request $request){

        ShippingPackages::where("id",$id)->update([
            "from_country"=>$request->from_country,
            "to_country"=>$request->to_country,
            "amount"=>0,
            "days"=>$request->days,
            "shipping_type"=>$request->shipping_type,
            "unit_types"=>json_encode($request->unit_types)
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);

    }
    function Delete($id,Request $request){
        ShippingPackages::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Deleted"
        ]);

    }
}
