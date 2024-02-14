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
        Schema::create('seller_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->integer("payment_method_id");
            $table->integer("order_id");
            $table->double("amount");
            $table->string("status");
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("cascade");
            $table->date("payment_date")->default(\Illuminate\Support\Facades\Date::now());
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
        Schema::dropIfExists('seller_payments');
    }
};
