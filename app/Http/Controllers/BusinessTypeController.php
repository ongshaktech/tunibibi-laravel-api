<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\BusinessType;
use App\Models\Seller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class BusinessTypeController extends Controller
{

    function index(){

        $data=BusinessType::get();

        $new_data=array();

        foreach ($data as $value){
            $current_Data=[
                "id"=>$value->id,
                "name"=>$value->name,
                "image"=>config("app.url")."storage/business/".$value->image,
                "created_at"=>$value->created_at,
                "updated_at"=>$value->updated_at
            ];

            array_push($new_data,$current_Data);
        }


        return $new_data;
    }


    //For Seller
    function update($id,Request $request){

        $check_shop_name_exists=Seller::where(["shop_name"=>$request->shop_name])->get();

        if(count($check_shop_name_exists)>0){
            return Response()->json(["error"=>true,"msg"=>"Already Shop Name Used"]);
        }else{
            $slug=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->shop_name)));
            $data=Seller::where(["id"=>$id])->update(["shop_name"=>$request->shop_name,"business_type_id"=>$request->business_type_id,"slug"=>$slug,"email"=>$request->email]);

            list($type, $imageData) = explode(';', $request->logo);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            Storage::disk("public")->put("logo/".$fileName,$imageData);
            $status=\App\Models\Seller::where("id",$id)->update(["logo"=>$fileName]);


            if($data==1){
                return response()->json(["error"=>false,"msg"=>"Business Type Updated Successfully"]);
            }else{
                return response()->json(["error"=>true,"msg"=>"Something Wrong"]);
            }
        }





    }


    function AddBussiness(Request $request){
        //For Admin
        list($type, $imageData) = explode(';', $request->image);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("business/".$fileName,$imageData);
        $id= BusinessType::insertGetId([
            "name"=>$request->name,
            "image"=>$fileName
        ]);

        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Added"
        ]);

    }

    function EditBusiness($id,Request $request){

        if(empty($request->image)){
            BusinessType::where("id",$id)->update([
                "name"=>$request->name,
            ]);

            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Updated"
            ]);
        }else{
            list($type, $imageData) = explode(';', $request->image);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            $image= BusinessType::where("id",$id)->first()->image;

            File::delete(config("app.url")."storage/products/".$image);
            Storage::disk("public")->put("business/".$fileName,$imageData);
            $id= BusinessType::where("id",$id)->update([
                "name"=>$request->name,
                "image"=>$fileName
            ]);

            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Updated"
            ]);
        }

    }


    function DeleteBusiness($id){
        BusinessType::where("id",$id)->delete();
        return Response::json([
            "error"=>false,
            "msg"=>"Successfully Deleted"
        ]);
    }





}
