<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class BuyerSecuritySettingsController extends Controller
{

    function Index(Request $request){
        $buyer_info=Buyer::where("id",$request->user()->id)->first();

        return Response::json([
            "error"=>false,
            "data"=>["email"=>$buyer_info->email,"phone"=>$buyer_info->number]
        ]);

    }

    function Update(Request $request){


        if(!empty($request->currentPass) && !empty($request->newPass) && !empty($request->confirmPass)){


            $check=Hash::check($request->currentPass,$request->user()->password);

            $error=[];

            if($check==false){
                $error["msg"]="Current Password was wrong";
            }
           else if($request->newPass!=$request->confirmPass){
                $error["msg"]="New Password and Confirm Password Not Match";
            }

           if(count($error)){
               return Response::json([
                   "error"=>false,
                   "msg"=>$error["msg"]
               ]);
           }else{

               $newpass=Hash::make($request->newPass);

               $update_data=[];
               $update_data["password"]=$newpass;

               if(!empty($request->email)){
                   $update_data["email"]=$request->email;
               }
               if(!empty($request->phone)){
                   $update_data["number"]=$request->phone;
               }
               Buyer::where("id",$request->user()->id)->update($update_data);

               return Response::json([
                   "error"=>false,
                   "msg"=>"Setting Update Successfully"
               ]);

           }



        }else{
            $update_data=[];
            if(!empty($request->email)){
                $update_data["email"]=$request->email;
            }
            if(!empty($request->phone)){
                $update_data["number"]=$request->phone;
            }
            Buyer::where("id",$request->user()->id)->update($update_data);

            return Response::json([
                "error"=>false,
                "msg"=>"Setting Update Successfully"
            ]);

        }



    }
}
