<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buyer_favourite_product extends Model
{
    use HasFactory;

    protected $fillable=["product_id","buyer_favourite_names_id","buyer_id"];
}
