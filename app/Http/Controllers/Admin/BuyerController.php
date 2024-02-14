<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Refers_Code;
use App\Models\ShippingPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class BuyerController extends Controller
{

    function Index(){
        $data=Buyer::all();

        return response()->json([
            "error"=> false,
            "data"=>$data
        ]);
    }

    function Store(Request $request){
        $country_code=substr($request->phone,0,4);
        $get_name=DB::table("country")->where("code","LIKE","%".strval($country_code)."%")->first()->name;
        $create_buyer=Buyer::insertGetId([
            "name"=>$request->name,
            "number"=>$request->number,
            "country"=>$get_name,
            "password"=>Hash::make($request->password),
            "email"=>$request->email,
            "address"=>$request->address,
            "city"=>$request->city,
            "postcode"=>$request->postcode,
            "is_active"=>1


        ]);
        $my_refer=Str::random(8);
        Refers_Code::create(["buyer_id"=>$create_buyer,"code"=>strtoupper($my_refer),"user_type"=>"BUYER"]);

        return response()->json([
            "error"=> false,
            "msg"=>"Successfully Created"
        ]);
    }


    function Update($id,Request $request){
        $country_code=substr($request->phone,0,4);
        $get_name=DB::table("country")->where("code","LIKE","%".strval($country_code)."%")->first()->name;
        $create_buyer=Buyer::where("id",$id)->update([
            "name"=>$request->name,
            "number"=>$request->number,
            "country"=>$get_name,
            "password"=>Hash::make($request->password),
            "email"=>$request->email,
            "address"=>$request->address,
            "city"=>$request->city,
            "postcode"=>$request->postcode,
            "is_active"=>1


        ]);

        return response()->json([
            "error"=> false,
            "msg"=>"Successfully Update"
        ]);
    }


    function Delete($id,Request $request){
        Buyer::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Deleted"
        ]);

    }

}
