<?php

namespace App\Http\Controllers;

use App\Models\BuyerPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BuyerPaymentMethodController extends Controller
{
    function Index(Request $request){

        $data=BuyerPaymentMethod::where(["country"=>$request->user()->country])->get();

        $payment_info=array();

        foreach ($data as $value){

            array_push($payment_info,[
               "id"=>$value->id,
               "name"=>$value->name,
               "extra_note"=>$value->extra_note,
               "country"=>$value->country,
               "is_bank"=>$value->is_bank,
               "details"=>json_decode($value->details),
               "logo"=>config("app.url")."storage/payment/method/".$value->logo,
            ]);

        }



        return Response::json([
            "error"=>false,
            "data"=>$payment_info
        ]);

    }


    function all(){
        $data=BuyerPaymentMethod::all();

        $payment_info=array();

        foreach ($data as $value){

            array_push($payment_info,[
                "id"=>$value->id,
                "name"=>$value->name,
                "extra_note"=>$value->extra_note,
                "country"=>$value->country,
                "is_bank"=>$value->is_bank,
                "details"=>json_decode($value->details),
                "logo"=>config("app.url")."storage/payment/method/".$value->logo,
            ]);

        }



        return Response::json([
            "error"=>false,
            "data"=>$payment_info
        ]);
    }

    function store(Request $request){
        list($type, $imageData) = explode(';', $request->logo);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("payment/method/".$fileName,$imageData);

        BuyerPaymentMethod::create([
            "name"=>$request->name,
            "details"=>json_encode($request->details),
            "extra_note"=>$request->extra_note,
            "country"=>$request->country,
            "is_bank"=>$request->is_bank,
            "logo"=>$fileName
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Stored"
        ]);

    }



    function update($id,Request $request){
        list($type, $imageData) = explode(';', $request->logo);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("payment/method/".$fileName,$imageData);

        BuyerPaymentMethod::where("id",$id)->update([
            "name"=>$request->name,
            "details"=>json_encode($request->details),
            "extra_note"=>$request->extra_note,
            "country"=>$request->country,
            "is_bank"=>$request->is_bank,
            "logo"=>$fileName
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Updated"
        ]);



    }
    function delete($id){
        BuyerPaymentMethod::where("id",$id)->delete();

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);

    }





}
