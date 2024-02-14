<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideos extends Model
{
    use HasFactory;

    protected $fillable=["title","desc","video_link","img","products","seller_id"];

}
