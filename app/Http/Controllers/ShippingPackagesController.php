<?php

namespace App\Http\Controllers;

use App\Models\ShippingPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ShippingPackagesController extends Controller
{
   function Show(Request $request){
       $data=ShippingPackages::where(["to_country"=>$request->user()->country])->get();
       $formated_data=array();

       forEach($data as $value){

           array_push($formated_data,[
            "id"=>$value->id,
            "from_country"=>$value->from_country,
            "to_country"=>$value->to_country,
            "amount"=>$value->amount,
            "days"=>$value->days,
            "shipping_type"=>$value->shipping_type,
            "unit_types"=>json_decode($value->unit_types),
            "created_at"=>$value->created_at,
            "updated_at"=>$value->updated_at,
           ]);
       }
       return Response::json([
           "error"=>false,
           "data"=>$formated_data
       ]);

   }



}
