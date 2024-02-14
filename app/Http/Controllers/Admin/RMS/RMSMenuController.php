<?php

namespace App\Http\Controllers\Admin\RMS;

use App\Http\Controllers\Controller;
use App\Models\RmsMenus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RMSMenuController extends Controller
{
   function index(){

      $data=RmsMenus::all();

      return Response::json([
          "error"=>false,
          "data"=>$data
      ]);
   }

    function store(Request $request){
        RmsMenus::create([
            "name"=>$request->name,
            "url"=>$request->url,
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }

    function update($id,Request $request){
        RmsMenus::where("id",$id)->update([
            "name"=>$request->name,
            "url"=>$request->url,
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function delete($id){
        RmsMenus::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }
}
