<?php

namespace App\Http\Controllers\Admin\RMS;

use App\Http\Controllers\Controller;
use App\Models\RmsGroups;
use App\Models\RmsMenus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RMSGroupsController extends Controller
{
    function index(){

        $data=RmsGroups::all();

        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function store(Request $request){
        RmsGroups::create([
            "group_name"=>$request->name,
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }

    function update($id,Request $request){
        RmsGroups::where("id",$id)->update([
            "group_name"=>$request->name
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function delete($id){
        RmsGroups::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }
}
