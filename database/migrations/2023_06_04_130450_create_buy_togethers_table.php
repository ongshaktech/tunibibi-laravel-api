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
        Schema::create('buy_togethers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->integer("quantity");
            $table->unsignedBigInteger("wholesale_id");
            $table->string("invite_link");
            $table->dateTime("expire_time");
            $table->string("country");
            $table->unsignedBigInteger("buyer_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
            $table->foreign("wholesale_id")->references("id")->on("wholesale_prices")->onDelete("cascade");
            $table->foreign("buyer_id")->references("id")->on("buyers")->onDelete("cascade");
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
        Schema::dropIfExists('buy_togethers');
    }
};
