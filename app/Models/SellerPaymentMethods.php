<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPaymentMethods extends Model
{
    use HasFactory;

    protected $table="payment_methods";

    protected $fillable=["method_name","method_details"];
}
