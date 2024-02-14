<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable=["seller_id","coupon_code","min_qty","usage_per_customer","discount_type","discount_value","min_order_amount","max_disc_amount","show_to_customer","is_public"];
    protected $table="coupons";
}
