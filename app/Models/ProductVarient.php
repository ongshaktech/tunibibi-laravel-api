<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVarient extends Model
{
    use HasFactory;

    protected $fillable=["user_id","name","color","varients"];
    protected $table="product_varients";

}
