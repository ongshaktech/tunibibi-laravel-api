<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";

    protected $fillable=["seller_id","product_name","catagory_id","sub_catagory_id","product_details","weight_unit","product_code","video_url","product_origin","weight_type","stock"."is_featured"];

}
