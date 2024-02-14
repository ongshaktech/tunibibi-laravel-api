<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\Seller;
use App\Models\SellerRechargeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RechargeRequestController extends Controller
{
   function Index(){

       $data=SellerRechargeRequest::all();

       $formated_data=array();
       foreach ($data as $value){
           $seller_info=Seller::where("id",$value->seller_id)->first();
           $seller_data=array();

           array_push($seller_data,[
               "id"=> $seller_info->id,
               "shop_name"=> $seller_info->shop_name,
               "phone"=>$seller_info->phone,
               "business_type_name"=> BusinessType::where("id",$seller_info->business_type_id)->first()->name,
               "address"=>$seller_info->address,
               "slug"=>$seller_info->slug,
               "email"=>$seller_info->email,
               "logo"=>config("app.url")."storage/logo/".$seller_info->logo
           ]);


           array_push($formated_data,[
               "seller_info"=>$seller_data,
               "recharge_info"=>$value
           ]);
       }

       return Response::json([
           "error"=>false,
           "data"=>$formated_data
       ]);

   }


   function Approve($id){
       SellerRechargeRequest::where("id",$id)->update(["status"=>"complete"]);
       return Response::json([
           "error"=>false,
           "msg"=>"Successfully Updated"
       ]);

   }
}
