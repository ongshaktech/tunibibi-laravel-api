<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_coupon extends Model
{
    use HasFactory;

    protected $fillable=["buyer_id","seller_id","coupon_id","is_used"];
}
