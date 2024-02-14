<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPackages extends Model
{
    use HasFactory;

    protected $fillable=["from_country","to_country","amount","days","shipping_type","unit_types"];
}
