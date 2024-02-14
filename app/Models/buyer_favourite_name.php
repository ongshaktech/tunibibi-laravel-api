<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buyer_favourite_name extends Model
{
    use HasFactory;

    protected $table="buyer_favourite_names";
    protected $fillable=["name","buyer_id"];
}
