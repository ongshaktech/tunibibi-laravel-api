<?php

namespace App\Http\Controllers\Admin\RMS;

use App\Http\Controllers\Controller;
use App\Models\RmsGroupMenus;
use App\Models\RmsGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RMSGroupMenusController extends Controller
{
    function index(){

        $data=RmsGroupMenus::all();

        $formated_data=array();

        foreach ($data as $value){
            array_push($formated_data,[
                "id"=>$value->id,
                "group_info"=>RmsGroups::where("id",$value->group_id)->first(),
                "menus"=>json_decode($value->menus)
            ]);
        }

        return Response::json([
            "error"=>false,
            "data"=>$formated_data
        ]);
    }

    function store(Request $request){
        RmsGroupMenus::create([
            "group_id"=>$request->group_id,
            "menus"=>json_encode($request->menus),
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }

    function update($id,Request $request){
        RmsGroupMenus::where("id",$id)->update([
            "group_id"=>$request->group_id,
            "menus"=>json_encode($request->menus),
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function delete($id){
        RmsGroupMenus::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }
}
