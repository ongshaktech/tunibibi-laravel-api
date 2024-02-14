<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerReferPolicy extends Model
{
    use HasFactory;

    protected $table="refer_earning_policy";

    protected $fillable=["policy"];
}
