<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTimes extends Model
{
    use HasFactory;

    protected $fillable=["times","minutes"];
    protected $table="delivery_times";
}
