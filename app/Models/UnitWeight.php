<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitWeight extends Model
{
    use HasFactory;

    protected $fillable=["unit_name"];

    protected $table="unit_weights";
}
