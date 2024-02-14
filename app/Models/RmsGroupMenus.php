<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmsGroupMenus extends Model
{
    use HasFactory;

    protected $table="rms_group_menus";

    protected $fillable=["group_id","menus"];
}
