<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buyer_shipping_address extends Model
{
    use HasFactory;
    protected $fillable=["name1","name2","mobile","street","apartment","country","state","city","zip","is_default","buyer_id"];
}
