<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmsPermissions extends Model
{
    use HasFactory;

    protected $table="rms_permissions";
    protected $fillable=["admin_id","group_id"];
}
