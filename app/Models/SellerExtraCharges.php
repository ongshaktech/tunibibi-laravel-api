<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerExtraCharges extends Model
{
    use HasFactory;
    protected $fillable=["seller_id","extra_charge_id","catagory_id","charge_amount"];

}
