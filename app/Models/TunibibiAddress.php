<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TunibibiAddress extends Model
{
    use HasFactory;


    protected $table="tunibibi_address";
    protected $fillable=["name","mobile","street","apartment","country","state","city","zip"];
}
