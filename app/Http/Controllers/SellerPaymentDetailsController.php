<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SellerPaymentDetails;
use App\Models\SellerPaymentMethods;
use App\Models\SellerPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SellerPaymentDetailsController extends Controller
{


    public function PaymentMethods(){
        $payment_info=array();
        $data=SellerPaymentMethods::all();
        foreach ($data as $value){
            array_push($payment_info,["id"=>$value->id,"method_name"=>$value->method_name,"method_details"=>json_decode($value->method_details)]);
        }
        return Response::json([
            "error"=>false,
            "msg"=>$payment_info
        ]);
    }
function PaymentMethodSave(Request $request){

        $check_if_exist=SellerPaymentDetails::where(["seller_id"=>$request->user()->id,"method_id"=>$request->id])->get();

        if(count($check_if_exist)>0){
            SellerPaymentDetails::updated(["method_details"=>json_encode($request->method_details)]);
            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Updated"
            ]);
        }else{
            SellerPaymentDetails::create(["seller_id"=>$request->user()->id,"method_id"=>$request->id,"method_details"=>json_encode($request->method_details)]);
            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Saved"
            ]);
        }


}
function MyPayments(Request $request){

        $payment_info=array();
        $payments_data=SellerPayments::where("seller_id",$request->user()->id)->get();

        foreach ($payments_data as $data){

            array_push($payment_info,["id"=>$data->id,"order_id"=>$data->order_id,"amount"=>$data->amount,"status"=>$data->status,"pay_time"=>date_format($data->created_at,"M d,h:m A")]);
        }


    return Response::json([
        "error"=>false,
        "data"=>$payment_info
    ]);

}
    public function  UpiPayment(Request $request){
        $data=SellerPaymentDetails::where(["Seller_id"=>$request->user()->id,"payment_type"=>"UPI"])->first();

        if($data!=null){
            return Response::json([
                "error"=>false,
                "payment_details"=>[
                    [
                        "upi_id"=>$data->upi_id,
                        "upi_account_name"=>$data->upi_account_name,
                    ]
                ]
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"No Payment Details Found"
            ]);
        }

    }
    public function UpiPaymentAdd(Request $request){
        $check_if_has=SellerPaymentDetails::where(["seller_id"=>$request->user()->id,"payment_type"=>"UPI"])->get();

        if(count($check_if_has)==0){
            SellerPaymentDetails::create(
                [
                    "seller_id"=>$request->user()->id,
                    "payment_type"=>"UPI",
                    "upi_id"=>$request->upi_id,
                    "upi_account_name"=>$request->upi_account_name,
                ]
            );
            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Payment Details Save"
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Already Payment Details Added.Please Update Payment Details"
            ]);
        }


    }
    public function UpiPaymentEdit(Request $request){
        $check_if_has=SellerPaymentDetails::where(["seller_id"=>$request->user()->id,"payment_type"=>"UPI"])->update(["upi_id"=>$request->upi_id,"upi_account_name"=>$request->upi_account_name,]);

       return Response::json(
           [
               "error"=>false,
               "msg"=>"Successfully Payment Details Updated"
           ]
       );


    }


    public function BankPayment(Request $request){
        $data=SellerPaymentDetails::where(["Seller_id"=>$request->user()->id,"payment_type"=>"BANK"])->first();

        if($data!=null){
            return Response::json([
                "error"=>false,
                "payment_details"=>[
                    [
                        "bank_name"=>$data->bank_name,
                        "bank_branch"=>$data->bank_branch,
                        "bank_account_name"=>$data->bank_account_name,
                        "bank_account_number"=>$data->bank_account_number
                    ]
                ]
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"No Payment Details Found"
            ]);
        }

    }
    public function BankPaymentAdd(Request $request){
        $check_if_has=SellerPaymentDetails::where(["seller_id"=>$request->user()->id,"payment_type"=>"BANK"])->get();

        if(count($check_if_has)==0){
            SellerPaymentDetails::create(
                [
                    "seller_id"=>$request->user()->id,
                    "payment_type"=>"BANK",
                    "bank_name"=>$request->bank_name,
                    "bank_branch"=>$request->bank_branch,
                    "bank_account_name"=>$request->bank_account_name,
                    "bank_account_number"=>$request->bank_account_number
                ]
            );
            return Response::json([
                "error"=>false,
                "msg"=>"Successfully Payment Details Save"
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Already Payment Details Added.Please Update Payment Details"
            ]);
        }


    }
    public function BankPaymentEdit(Request $request){
        $check_if_has=SellerPaymentDetails::where(["seller_id"=>$request->user()->id,"payment_type"=>"BANK"])->update([
            "bank_name"=>$request->bank_name,
            "bank_branch"=>$request->bank_branch,
            "bank_account_name"=>$request->bank_account_name,
            "bank_account_number"=>$request->bank_account_number
        ]);

        return Response::json(
            [
                "error"=>false,
                "msg"=>"Successfully Payment Details Updated"
            ]
        );


    }



    public function CODAdd(Request $request){
        $check_if_has=SellerPaymentDetails::where(["seller_id"=>$request->user()->id,"payment_type"=>"COD"])->get();

        if(count($check_if_has)==0){
            $data=SellerPaymentDetails::create(["seller_id"=>$request->user()->id,"payment_type"=>"COD"]);

            if($data!=null){
                return Response::json([
                    "error"=>false,
                    "msg"=>"Successfully Payment Details Save"
                ]);
            }

        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"Already Payment Details Added.Please Update Payment Details"
            ]);
        }


    }
   public function CODGet(Request $request){
    $data=SellerPaymentDetails::where(["Seller_id"=>$request->user()->id,"payment_type"=>"COD"])->first();

    if($data!=null){
        return Response::json([
            "error"=>false,
            "payment_details"=>[
                [
                    "id"=>$data->id,
                    "payment_type"=>"COD",
                ]
            ]
        ]);
    }else{
        return Response::json([
            "error"=>true,
            "msg"=>"No Payment Details Found"
        ]);
    }

}


    public function  AllPaymentsDetails(Request $request){
        $data=SellerPaymentDetails::where(["Seller_id"=>$request->user()->id])->get();

        if($data!=null){
            return Response::json([
                "error"=>false,
                "payment_details"=>$data
            ]);
        }else{
            return Response::json([
                "error"=>true,
                "msg"=>"No Payment Details Found"
            ]);
        }

    }
}
