<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buyer_shipping extends Model
{
    use HasFactory;

    protected $fillable=["buyer_id","shipping_package_id"];
}
