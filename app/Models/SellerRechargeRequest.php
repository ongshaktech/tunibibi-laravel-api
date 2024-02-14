<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRechargeRequest extends Model
{
    use HasFactory;

    protected $table="seller_recharge_requests";

    protected $fillable=["country_name","code","mobile_no","operator","amount"];
}
