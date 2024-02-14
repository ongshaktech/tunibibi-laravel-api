<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    function Sellers(){

        $shop_info=Seller::where("sellers.id","!=",0)->get();

        $new_data=array();
        if($shop_info!=null){


            foreach ($shop_info as $value){
                array_push($new_data,[
                    "id"=> $value->id,
                    "shop_name"=> $value->shop_name,
                    "phone"=>$value->phone,
                    "business_type_name"=>BusinessType::where("id",$value->business_type_id)->first()!=null?BusinessType::where("id",$value->business_type_id)->first()->name:null,
                    "address"=>$value->address,
                    "slug"=>$value->slug,
                    "email"=>$value->email,
                    "logo"=>config("app.url")."storage/logo/".$value->logo
                ]);

            }
            return response()->json([
                "error"=>false,
                "data"=>$new_data
            ]);

        }else{
            return response()->json([
                "error"=>true,
                "msg"=>"Not Found!"
            ]);
        }
    }

    function RegistrationSeller(Request $request){

        $check_shop_name_exists=Seller::where(["shop_name"=>$request->shop_name])->get();
        $check_shop_phone_exists=Seller::where(["phone"=>$request->phone])->get();

        if(count($check_shop_name_exists)>0){
            return Response()->json(["error"=>true,"msg"=>"Already Shop Name Used"]);
        }
        else if(count($check_shop_phone_exists)>0){
            return Response()->json(["error"=>true,"msg"=>"Already Phone Used"]);
        }
        else{
            $slug=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->shop_name)));
            $seller_id=Seller::insertGetId(["shop_name"=>$request->shop_name,"country"=>$request->country,"business_type_id"=>$request->business_type_id,"slug"=>$slug,"email"=>$request->email,"phone"=>$request->phone,"password"=>Hash::make($request->password)]);

            list($type, $imageData) = explode(';', $request->logo);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            Storage::disk("public")->put("logo/".$fileName,$imageData);
            $status=\App\Models\Seller::where("id",$seller_id)->update(["logo"=>$fileName]);

            return response()->json(["error"=>false,"msg"=>"Business Type Updated Successfully"]);
        }

    }

    function UpdateSeller($id,Request $request){
        $seller_id=Seller::where("id",$id)->update(["shop_name"=>$request->shop_name,"business_type_id"=>$request->business_type_id,"address"=>$request->address,"is_active"=>$request->is_active]);

        if(!empty($request->logo)){
            list($type, $imageData) = explode(';', $request->logo);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);

            $seller_id=Seller::where("id",$id)->first();

            File::delete(config("app.url")."storage/logo/".$seller_id->logo);

            Storage::disk("public")->put("logo/".$fileName,$imageData);
            $status=\App\Models\Seller::where("id",$seller_id)->update(["logo"=>$fileName]);
        }


        return response()->json(["error"=>false,"msg"=>"Successfully Updated"]);
    }


    function DeleteSeller($id){
        Seller::where("id",$id)->delete();
        return response()->json(["error"=>false,"msg"=>"Successfully Deleted"]);
    }

    function ChangePassword($id,Request $request){
        Seller::where(["id"=>$id])->update(["password"=>Hash::make($request->password)]);
        return response()->json(["error"=>false,"msg"=>"Successfully Updated"]);
    }

    function Country(){
        $data = DB::table("country")->get();
        $new_data = array();
        foreach ($data as $value) {
            array_push($new_data, [
                "name" => $value->name,
                "code" => $value->code,
                "flag" => config("app.url") . "storage/country/" . $value->flag,
                "dollar_rate" => $value->dollar_rate,
                "currency_type" => $value->currency_type,
            ]);
        }

        return response()::json([
            "error" => false,
            "data" => $new_data
        ]);

        // return response()->json(["error"=>false,"data_"=>$data]);
    }
}
