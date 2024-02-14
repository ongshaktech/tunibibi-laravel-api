<?php

namespace App\Http\Controllers\Admin\RMS;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\RmsGroupMenus;
use App\Models\RmsMenus;
use App\Models\RmsPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RMSPermissionController extends Controller
{
    function index(){

        $data=RmsPermissions::all();


        $formated_data=array();

        foreach ($data as $value){
            $user_info=admin::select("id","name","user_type","is_active")->where("id",$value->admin_id)->first();
            $group_data=array();

            $groups=RmsGroupMenus::whereIn("id",json_decode($value->group_id))->get();


            foreach ($groups as $group_value){

                $group_menus=json_decode($group_value->menus);

                foreach ($group_menus as $group_menus_value){
                    array_push($group_data,$group_menus_value);
                }


            }

            array_push($formated_data,[
                "id"=>$value->id,
                "user_info"=>$user_info,
                "menus"=>$group_data
            ]);
        }

        return Response::json([
            "error"=>false,
            "data"=>$formated_data
        ]);
    }


    function myPermission(Request $request){

        $data=RmsPermissions::where("admin_id",$request->user()->id)->get();
        $group_data=array();

        foreach ($data as $value){
            $groups=RmsGroupMenus::whereIn("id",json_decode($value->group_id))->get();


            foreach ($groups as $group_value){

                $group_menus=json_decode($group_value->menus);

                foreach ($group_menus as $group_menus_value){
                    array_push($group_data,[
                        "name"=>RmsMenus::where("url",$group_menus_value)->first()->name,
                        "link"=>$group_menus_value,
                    ]);
                }
            }
        }

        return Response::json([
            "error"=>false,
            "data"=>$group_data
        ]);
    }

    function store(Request $request){
        RmsPermissions::create([
            "admin_id"=>$request->user_id,
            "group_id"=>json_encode($request->group_id),

        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Saved"
        ]);
    }

    function update($id,Request $request){
        RmsPermissions::where("id",$id)->update([
            "admin_id"=>$request->user_id,
            "group_id"=>json_encode($request->group_id),
        ]);


        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);
    }

    function delete($id){
        RmsPermissions::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }


    function checkPermission(Request $request){

        $permission_status=false;

        $data=RmsPermissions::where("admin_id",$request->user()->id)->get();

        $group_data=array();
        foreach ($data as $value){
            $user_info=admin::select("id","name","user_type","is_active")->where("id",$value->admin_id)->first();


            $groups=RmsGroupMenus::whereIn("group_id",json_decode($value->group_id))->get();


            foreach ($groups as $group_value){

                $group_menus=json_decode($group_value->menus);

                foreach ($group_menus as $group_menus_value){
                    array_push($group_data,$group_menus_value);

                }


            }




        }
        $permission_status=in_array($request->url,$group_data);

        if($request->user()->user_type=="SUPER ADMIN"){
            $permission_status=true;
        }

        return Response::json([
            "is_permission"=>$permission_status
        ]);;
    }


}
