<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholesalePrice extends Model
{
    use HasFactory;

    protected $fillable=["product_id","min_quantity","max_quantity","amount","unit"];
    protected $table="wholesale_prices";
}
