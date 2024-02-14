<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table="orders";
    use HasFactory;
     protected $fillable=["buyer_id","seller_id","order_id","product_id","quantity","wholesale_info","varient_info","coupon_info","product_price","amount","disc_amount","shipping_info","shipping_charge","delivery_charge","buyer_shipping_addresses_info","wirehouse_id","order_status_seller","delivery_time","delivery_payment_status","payment_status","date","order_status_user","charges","orders_type","track_id","estimated_date","variant_id","dollar_rate","estimate_delivery_date","unit_weight","unit_type","seller_delivery_info","can_buytogether","seller_delivery_charge","voucher_info","total_amount","order_with","payment_method_id","customer_shipping_fee","customer_delivery_fee","status_warehouse","wirehouse_note","destination_wirehouse_id","destination_wirehouse_note","shipping_weight"];
}
