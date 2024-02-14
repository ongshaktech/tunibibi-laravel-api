<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buy_together extends Model
{
    use HasFactory;

    protected $fillable=["product_id","quantity","wholesale_id","invite_link","expire_time","country","buyer_id","size","product_varient_id","is_complete","voucher_id"];
}
