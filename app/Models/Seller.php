<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


use Illuminate\Database\Eloquent\Model;

class Seller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   protected $fillable=["phone","email","shop_name","business_type_id","logo","password","address","slug","country"];

    protected $table="sellers";
}
