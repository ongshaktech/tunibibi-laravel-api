<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    use HasFactory;

    protected $fillable=["seller_id","title","fb_rtmp","youtube_rtmp","products","start_time","end_time"];
    protected $table="lives";
}
