<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    use HasFactory;


    protected $fillable=["seller_id","buyer_id","product_id","quantity","variant_id","variant_info","is_checkout","wholesale_id","is_selected"];

}
