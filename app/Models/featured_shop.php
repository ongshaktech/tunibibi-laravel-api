<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class featured_shop extends Model
{
    use HasFactory;

    protected $fillable=["shop_id","video","products_id","country"];
}
