<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DeliveryTimesController extends Controller
{

    function DeliveryTimes(){

        $data=DeliveryTimes::all();
        return Response::json([
            "error"=>false,
            "data"=>$data
        ]);

    }

}
