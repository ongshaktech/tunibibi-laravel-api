<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCatagory extends Model
{
    use HasFactory;

    protected $fillable=["catagory_id","sub_catagory_name","sub_catagory_img"];
    protected $table="sub_catagory";

}
