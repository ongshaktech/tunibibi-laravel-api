<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerCurierCharges extends Model
{
    use HasFactory;
    protected $fillable=["seller_id","charge","above_amount","courier_details"];
    protected $table="seller_courier_charges";
}
