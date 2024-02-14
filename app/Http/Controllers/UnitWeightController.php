<?php

namespace App\Http\Controllers;

use App\Models\UnitWeight;
use Illuminate\Http\Request;

class UnitWeightController extends Controller
{
    function Weights(){

        $data=UnitWeight::all(["id","unit_name"]);
        return response()->json([
            "error"=>false,
            "data"=>$data
        ], );
    }
}
