<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class wirehouse extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable=["country","name","address","number","city","postcode","password","payment_method"];

    protected $hidden=["password"];
}
