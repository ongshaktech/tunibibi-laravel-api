<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersTree extends Model
{
    use HasFactory;

    protected $fillable=["buyer_id","orders_id","discount_amount","product_payment","delivery_payment","customer_order_id","status","payable_amount"];
}
