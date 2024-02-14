<?php

namespace App\Http\Controllers;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ProductReviewController extends Controller
{
function WriteReview($id,Request $request){

    ProductReview::create(["product_id"=>$id,"user_id"=>$request->user()->id,"rating"=>$request->rating,"comment"=>$request->comment]);

    return Response::json(
        [
            "error"=>false,
            "msg"=>"Successfully Added Review"
        ]
    );
}
}
