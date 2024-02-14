<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function Login(Request $request){

        $user=admin::where("email",$request->email)->first();

        if($user!=null){

            if(Hash::check($request->password,$user->password)){
                $token=$user->createToken($request->email)->plainTextToken;
                return response()->json([
                    "error"=>false,
                    "token"=>$token,
                    "user_type"=>$user->user_type
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
