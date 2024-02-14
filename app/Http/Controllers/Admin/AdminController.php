<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{

    public function users(){
        $data=admin::all();
        $formatted_data=array();

        foreach ($data as $value){
            array_push($formatted_data,[
                "id"=>$value->id,
                "email"=>$value->email,
                "user_type"=>$value->user_type,
                "is_active"=>$value->is_active
            ]);
        }

        return Response::json([
            "error"=>false,
            "data"=>$formatted_data
        ]);

    }
}
