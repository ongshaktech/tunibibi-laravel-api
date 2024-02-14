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
        Schema::create('buy_nows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("buyer_id");
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("shipping_id");
            $table->unsignedBigInteger("varient_id");
            $table->unsignedBigInteger("voucher_id")->nullable();
            $table->integer("quantity")->default(0);
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
        Schema::dropIfExists('buy_nows');
    }
};
