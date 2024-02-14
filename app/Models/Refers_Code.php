<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refers_Code extends Model
{
    use HasFactory;

    protected $fillable=["seller_id","buyer_id","code","user_type"];
    protected $table="refers_code";
}
