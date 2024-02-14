<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPaymentDetails extends Model
{
    use HasFactory;


    protected $fillable=["seller_id","method_id","method_details"];

}
