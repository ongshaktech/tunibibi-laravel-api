<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmsMenus extends Model
{
    use HasFactory;

    protected $table="rms_menus";
    protected $fillable=["name","url"];
}
