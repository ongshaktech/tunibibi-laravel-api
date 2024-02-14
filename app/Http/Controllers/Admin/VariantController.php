<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VariantController extends Controller
{


    function Index(){
        $all_data=ProductVarient::all();

        $data=array();

        foreach ($all_data as $value){
            array_push($data,["id"=>$value->id,"name"=>$value->name,"color"=>strval(config("app.url")."storage/varients/".$value->color),"varients"=>json_decode($value->varients)]);
        }

        return response()->json([
            "error"=>false,
            "data"=>$data
        ]);
    }

    function Store(Request $request){


        list($type, $imageData) = explode(';', $request->color);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("varients/".$fileName,$imageData);

        $data_insert=ProductVarient::create([
            "user_id"=>$request->seller_id,
            "name"=>$request->name,
            "color"=>$fileName,
            "varients"=>json_encode($request->varients)
        ]);


        $data=ProductVarient::where("id",$data_insert->id)->get();

        $all_varients=array();

        foreach ($data as $d){
            $new_a=["id"=>$d->id,"name"=>$d->name,"color"=>config("app.url")."storage/varients/".$d->color,"varients"=>json_decode($d->varients)];
            array_push($all_varients,$new_a);

        }

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Added",
            "data"=>$all_varients
        ]);

    }

    function Update($id,Request $request){
        $all_varients=array();
        if($request->color!=null && !empty($request->color)){
            list($type, $imageData) = explode(';', $request->color);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            $data=ProductVarient::where("id",$id)->get();

            foreach ($data as $datas){
                File::delete(config("app.url")."storage/varients/".$datas->color);
            }


            Storage::disk("public")->put("varients/".$fileName,$imageData);
            $data_insert=ProductVarient::where(["id"=>$id])->update([
                "name"=>$request->name,
                "color"=>$fileName,
                "varients"=>json_encode($request->varients)
            ]);

        }else{
            $data_insert=ProductVarient::where(["id"=>$id])->update([
                "user_id"=>$request->user()->id,
                "name"=>$request->name,
                "varients"=>json_encode($request->varients)
            ]);

        }


        $data=ProductVarient::where("id",$id)->get();



        foreach ($data as $d){

            $new_a=["id"=>$d->id,"name"=>$d->name,"color"=>config("app.url")."storage/varients/".$d->color,"varients"=>json_decode($d->varients)];

            array_push($all_varients,$new_a);


        }



        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Updated",
            "data"=>$all_varients
        ]);

    }


    function Delete($id){

        $data=ProductVarient::where("id",$id)->get();

        foreach ($data as $datas){
            File::delete(config("app.url")."storage/varients/".$datas->color);
        }



        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);

    }


    }
