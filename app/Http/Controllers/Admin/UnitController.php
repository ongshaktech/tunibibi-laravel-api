<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UnitController extends Controller
{

    function index(){
        $data=UnitWeight::all();
        return Response()->json(["error"=>false,"data"=>$data]);
    }
    function create(Request $request){
       UnitWeight::create(["unit_name"=>$request->unit_name]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Added"]);
    }
    function update($id,Request $request){
        UnitWeight::where("id",$id)->update(["unit_name"=>$request->unit_name]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Updated"]);
    }
    function delete($id){
        UnitWeight::where("id",$id)->delete();
        return Response()->json(["error"=>false,"msg"=>"Successfully Deleted"]);
    }
}
