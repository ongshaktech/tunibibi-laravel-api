<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmsGroups extends Model
{
    use HasFactory;

    protected $table="rms_groups";
    protected $fillable=["group_name"];
}
