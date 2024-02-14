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
        Schema::create('orders_trees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("buyer_id");
            $table->json("orders_id");
            $table->float("discount_amount");
            $table->string("product_payment")->default("pending");
            $table->string("delivery_payment")->default("pending");
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
        Schema::dropIfExists('orders_trees');
    }
};
