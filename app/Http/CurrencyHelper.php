<?php

namespace App\Http;

use App\Models\Country;

 class CurrencyHelper
{

     public static function CurrectConverter($country,$amount){
        $dollar_rate=Country::where(["name"=>$country])->first()->dollar_rate;
        $convert_amount=$amount*$dollar_rate;
        return $convert_amount;
    }

     public static function CurrecTypeInfo($country){
        $dollar_rate=Country::where(["name"=>$country])->first();
        $currency_type=$dollar_rate->currency_type;

        return $currency_type;
    }

     public static function GetCurrentDollarRate($country){
         $dollar_rate=Country::where(["name"=>$country])->first()->dollar_rate;

         return $dollar_rate;
     }

}
