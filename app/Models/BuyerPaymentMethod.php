<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerPaymentMethod extends Model
{
    use HasFactory;
    protected $fillable=["name","details","extra_note","country","is_bank","logo"];
}
