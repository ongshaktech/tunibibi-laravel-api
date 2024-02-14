<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerReferPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReferEarningPolicyController extends Controller
{
   function Index(){
       $data_info=SellerReferPolicy::select("id","policy")->get();

       return Response::json([
           "error"=>false,
           "data"=>$data_info
       ]);
   }

   function Store(Request $request){
       SellerReferPolicy::create([
           "policy"=>$request->policy
       ]);
       return Response::json([
           "error"=>false,
           "msg"=>"Succsfully Saved"
       ]);

   }
    function Update($id,Request $request){
        SellerReferPolicy::where("id",$id)->update([
            "policy"=>$request->policy
        ]);
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Updated"
        ]);

    }
    function Delete($id,Request $request){
        SellerReferPolicy::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Succsfully Deleted"
        ]);

    }
}
