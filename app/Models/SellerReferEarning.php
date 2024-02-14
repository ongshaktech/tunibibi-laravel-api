<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerReferEarning extends Model
{
    use HasFactory;
    protected $fillable=["seller_id","coins","refer_user_type","refered_buyer_id","refered_seller_id"];
}
