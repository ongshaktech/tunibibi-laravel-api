<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SearchHistoryController extends Controller
{

    function index(){
        $data=SearchHistory::all();
        $formatted_data=array();

        foreach ($data as $value){
            $user=Buyer::where("id",$value->buyer_id)->first();

            $user_info=[
                "image"=>$user->image==null?null:config("app.url")."storage/buyer/".$user->image,
                "name"=>$user->name,
                "address"=>$user->address,
                "country"=>$user->country,

            ];
            array_push($formatted_data,
            [
                "buyer_info"=>$user_info,
            "search_value"=>$value->search_value,
            "category_name"=>$value->category_name,
            "created_at"=>$value->created_at,
            "updated_at"=>$value->updated_at
            ]
            );
        }

        return Response::json([
            "error"=>false,
            "data"=>$formatted_data
        ]);
    }

}
