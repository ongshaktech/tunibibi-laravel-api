<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\BuyerReferEarning;
use App\Models\otp as Otp;
use App\Models\Refers_Code;
use App\Models\Seller;
use App\Models\SellerReferEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class BuyerController extends Controller
{


    function CheckNumber(Request $request){

       $data_buyer=Buyer::where("number","=",$request->phone)->get();
       $data_seller=Seller::where("phone","=",$request->phone)->get();
        if(count($data_buyer)>0 || count($data_seller)>0){
            return Response::json([
                "error"=>true,
                "msg"=>"Already Number Used"
            ]);
        }else{
            return Response::json([
                "error"=>false,
                "msg"=>"Success"
            ]);
        }

    }
   function OtpSend(Request $request){
           $otp=rand(100000,900000);

           $check_number_exists=Buyer::where("number",$request->phone)->first();

           if($check_number_exists!=null){
               return response()->json([
                   "error"=> true,
                   "msg"=>"Already Number Used!"
               ]);
           }else{
               if($request->refer!=null){
                   $refer_code=Refers_Code::where("code",$request->refer)->first();
                   if($refer_code!=null){

                       $status=Otp::create(["phone"=>$request->phone,"otp"=>$otp]);

                       if($status!=null){

                           $country_code=substr($request->phone,0,4);
                           $get_name=DB::table("country")->where("code","LIKE","%".strval($country_code)."%")->first()->name;
                           $create_buyer=Buyer::insertGetId(["number"=>$request->phone,"country"=>$get_name,"password"=>Hash::make($request->password),"is_active"=>0]);
                           $my_refer=Str::random(8);
                           Refers_Code::create(["buyer_id"=>$create_buyer,"code"=>strtoupper($my_refer),"user_type"=>"BUYER"]);

                           return response()->json([
                               "error"=> false,
                               "otp"=>$otp,
                               "buyer"=>$create_buyer
                           ]);
                       }else{
                           return response()->json([
                               "error"=> true,
                               "msg"=>"Something Wrong!"
                           ]);
                       }

                   }else{
                       return response()->json([
                           "error"=> true,
                           "msg"=>"Invalid Refer Code"
                       ]);
                   }


               }else{


                   $status=Otp::create(["phone"=>$request->phone,"otp"=>$otp]);

                   $country_code=substr($request->phone,0,4);
                   $get_name=DB::table("country")->where("code","LIKE","%".strval($country_code)."%")->first()->name;
                   $create_buyer=Buyer::insertGetId(["number"=>$request->phone,"country"=>$get_name,"password"=>Hash::make($request->password),"is_active"=>0]);
                   $my_refer=Str::random(8);
                   Refers_Code::create(["buyer_id"=>$create_buyer,"code"=>strtoupper($my_refer),"user_type"=>"BUYER"]);


                   if($status!=null){
                       return response()->json([
                           "error"=> false,
                           "otp"=>$otp,
                           "buyer_id"=>$create_buyer
                       ]);

                   }else{
                       return response()->json([
                           "error"=> true,
                           "msg"=>"Something Wrong!"
                       ]);
                   }

               }


           }

   }
    function verify($id,Request $request){
        $buyer_info=Buyer::where("id",$id)->get();
        if(count($buyer_info)>0){

            $buyer_info=Buyer::where("id",$id)->first();
            $data=Otp::where(["phone"=>$buyer_info->number,"otp"=>$request->otp,"is_used"=>0])->first();


            if($data!=null && $data->is_used==0){
                Otp::where(["phone"=>$buyer_info->number])->update(["is_used"=>1]);
                Buyer::where("id",$id)->update(["is_active"=>1]);

                $token=$buyer_info->createToken($buyer_info->number)->plainTextToken;

                return response()->json(["error"=>false,"msg"=>"Verification Complete","token"=>$token]);
            }else{
                return response()->json(["error"=>true,"msg"=>"Wrong OTP"]);
            }
        }else{
            return response()->json(["error"=>true,"msg"=>"Wrong Information"]);
        }




    }

    function Login(Request $request){

        $user=Buyer::where(["number"=>$request->phone,"is_active"=>1])->first();

        if($user!=null){

            if(Hash::check($request->password,$user->password)){
                $token=$user->createToken(strval($request->number))->plainTextToken;
                return response()->json([
                    "error"=>false,
                    "token"=>$token
                ]);
            }else{
                return response()->json([
                    "error"=>true,
                    "msg"=>"Wrong Information!"
                ]);
            }



        }else{
            return response()->json([
                "error"=>true,
                "msg"=>"Wrong Information!"
            ]);
        }

    }

}
