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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->unsignedBigInteger("buyer_id");
            $table->unsignedBigInteger("product_id");
            $table->integer("quantity");
            $table->unsignedBigInteger("variant_id");
            $table->json("variant_info");
            $table->integer("is_checkout")->default(0);
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("CASCADE");
            $table->foreign("buyer_id")->references("id")->on("buyers")->onDelete("CASCADE");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("CASCADE");
            $table->foreign("variant_id")->references("id")->on("product_varients")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
