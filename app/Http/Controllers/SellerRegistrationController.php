<?php

namespace App\Http\Controllers;

use App\Models\otp;
use Faker\Core\Number;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class SellerRegistrationController extends Controller
{

   function PasswordSetup($id,Request $request){

    $status=Seller::where(["id"=>$id])->update(["password"=>Hash::make($request->password)]);



    if($status==1){
        $seller=Seller::where(["id"=>$id])->get()->first();

        $token=$seller->createToken($seller->phone)->plainTextToken;


        return response()->json(
            [
                "error"=>false,
                "msg"=>"Successfully Password Setup",
                "token"=>$token

            ]
        );
    }else{
        return response()->json(
            [
                "error"=>true,
                "msg"=>"Something Wrong!"

            ]
        );
    }


   }

function MatchOtp(Request $request){
       $data=otp::where(["phone"=>$request->phone,"otp"=>$request->otp,"is_used"=>"0"])->get();
       if(count($data)>0){

           Otp::where(["id"=>$data[0]->id])->update(["is_used"=>1]);
           return Response()->json(["error"=>false,"msg"=>"OTP Match"]);

       }else{
           return Response()->json(["error"=>true,"msg"=>"OTP Not Match"]);
       }
}

   function ForgetOtp(Request $request){

        $user=Seller::where(["phone"=>$request->phone])->get();
        if(count($user)>0){
            $otp=rand(999999,100000);
            otp::create(["phone"=>$user[0]->phone,"otp"=>$otp]);
            return Response()->json(["error"=>false,"otp"=>$otp]);
        }else{
            return Response()->json(["error"=>true,"msg"=>"Number Not Found!"]);
        }


   }
    function ForgetPasswordSetup(Request $request){
        Seller::where(["phone"=>$request->phone])->update(["password"=>Hash::make($request->password)]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Password Updated"]);

    }
   function Login(Request $request){

    $user=Seller::where("phone",$request->phone)->first();

    if($user!=null){

        if(Hash::check($request->password,$user->password)){
            $token=$user->createToken($request->phone)->plainTextToken;
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

function ChangePassword(Request $request){
        $user=Seller::where("id",$request->user()->id)->first();
        if(Hash::check($request->password,$user->password)){

            if($request->new_password1===$request->new_password2){
                 Seller::where(["id"=>$request->user()->id])->update(["password"=>Hash::make($request->new_password1)]);
        return Response()->json(["error"=>false,"msg"=>"Successfully Password Updated"]);
            }else{
                 return response()->json([
                "error"=>true,
                "msg"=>"Password Not Match"
            ]);
            }


        }else{
            return response()->json([
                "error"=>true,
                "msg"=>"Wrong Old Password!"
            ]);
        }


}

    function RefreshToken(Request $request){
        $user=Seller::where("phone",$request->phone)->first();
        $token=$user->createToken($request->phone)->plainTextToken;
        return response()->json([
            "error"=>false,
            "token"=>$token
        ]);
    }

   function AddAddress(Request $request){



    $status=Seller::where(["id"=>$request->user()->id])->update(["address"=>$request->address]);



    if($status==1){

        return response()->json(
            [
                "error"=>false,
                "msg"=>"Successfully Address Updated"
            ]
        );
    }else{
        return response()->json(
            [
                "error"=>true,
                "msg"=>"Something Wrong!"
            ]
        );
    }
   }


   function Currency(Request $request){
       $data=DB::table("country",$request->user()->country)->first();
       $new_data=array();
       array_push($new_data,[
           "name"=>$data->name,
           "code"=>$data->code,
           "flag"=>config("app.url")."storage/country/".$data->flag,
           "dollar_rate"=>$data->dollar_rate,
           "currency_type"=>$data->currency_type,
       ]);
       return response()->json(["error"=>false,"data"=>$new_data]);
   }

}
