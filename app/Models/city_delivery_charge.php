<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city_delivery_charge extends Model
{
    use HasFactory;

    protected $fillable=["country_name","city_name","amount"];
}
