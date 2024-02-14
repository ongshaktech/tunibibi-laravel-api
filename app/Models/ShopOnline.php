<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOnline extends Model
{
    use HasFactory;

    protected $fillable=["shop_id","from_time","to_time","from_date","to_date"];
    protected $table="shop_onlines";
}
