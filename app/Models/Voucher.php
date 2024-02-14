<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable=["user_id","user_type","voucher_code","min_amount","amount","expire_date","is_used","is_selected"];
}
