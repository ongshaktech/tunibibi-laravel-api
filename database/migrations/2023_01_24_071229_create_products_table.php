<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("seller_id");
            $table->string("product_name");
            $table->unsignedBigInteger("catagory_id");
            $table->unsignedBigInteger("sub_catagory_id");
            $table->string("product_details");
            $table->string("weight_unit");
            $table->string("product_code");
            $table->string("video_url")->nullable();
            $table->string("product_origin");
            $table->foreign("catagory_id")->references("id")->on("catagory")->onDelete("cascade");
            $table->foreign("sub_catagory_id")->references("id")->on("sub_catagory")->onDelete("cascade");
            $table->date("date")->default(\Illuminate\Support\Facades\Date::now());
            $table->integer("is_active")->default(1);
            $table->timestamp("created_at")->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamp("updated_at")->default(DB::raw("CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
