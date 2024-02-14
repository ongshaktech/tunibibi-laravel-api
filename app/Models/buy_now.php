<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buy_now extends Model
{
    use HasFactory;

    protected $fillable=["buyer_id","product_id","shipping_id","varient_id","quantity","voucher_id","varient_info"];
}
