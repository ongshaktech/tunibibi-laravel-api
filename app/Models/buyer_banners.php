<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buyer_banners extends Model
{
    use HasFactory;

    protected $fillable=["image","country"];
}
