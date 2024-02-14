<?php
namespace App\Http\Controllers;
use App\Models\Refers_Code;
use App\Models\SellerReferEarning;
use Illuminate\Http\Request;
use App\Models\otp as Otp;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OtpController extends Controller
{

    function create(Request $request){


        $otp=rand(100000,900000);

        $check_number_exists=Seller::where("phone",$request->phone)->first();

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
                        return response()->json([
                            "error"=> false,
                            "otp"=>$otp
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

                if($status!=null){
                    return response()->json([
                        "error"=> false,
                        "otp"=>$otp
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





    function verify(Request $request){


        $data=Otp::where(["phone"=>$request->phone,"otp"=>$request->otp])->get()->last();

        $check_exist=Seller::where(["phone"=>$request->phone])->get();

        if(count($check_exist)==0){

            if($data!=null){
                Otp::where(["phone"=>$request->phone,"otp"=>$request->otp])->update(["is_used"=>1]);
                $country_code=substr($request->phone,0,4);
                $get_name=DB::table("country")->where("code","LIKE","%".strval($country_code)."%")->first()->name;
                $create_seller=Seller::insertGetId(["phone"=>$request->phone,"country"=>$get_name]);
                $my_refer=Str::random(8);
                Refers_Code::create(["seller_id"=>$create_seller,"code"=>strtoupper($my_refer),"user_type"=>"SELLER"]);

                //Refer Earning
                if($request->refer!=null){
                  $refer_code=Refers_Code::where("code",$request->refer)->first();
                  if($refer_code!=null){

                      if($refer_code->user_type=="SELLER"){
                        SellerReferEarning::create(["seller_id"=>$refer_code->seller_id,"coins"=>10,"refered_seller_id"=>$create_seller->id,"refer_user_type"=>"SELLER"]);
                      }
                      if($refer_code->user_type=="BUYER"){
                          SellerReferEarning::create(["buyer_id"=>$refer_code->buyer_id,"coins"=>10,"refered_seller_id"=>$create_seller->id,"refer_user_type"=>"SELLER"]);
                      }
                  }else{
                      return response()->json(["error"=>true,"msg"=>"Invalid Refer Code"]);
                  }
                }



                return response()->json(["error"=>false,"msg"=>"Verification Complete","seller_id"=>$create_seller]);
            }else{
                return response()->json(["error"=>true,"msg"=>"Wrong Otp!"]);
            }
        }else{
            return response()->json(["error"=>true,"msg"=>"Already Number Used"]);
        }





    }






}
