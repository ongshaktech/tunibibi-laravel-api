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
        Schema::create('seller_courier_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->double("charge");
            $table->double("above_amount");
            $table->string("courier_details");
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("cascade");
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
        Schema::dropIfExists('seller_curier_charges');
    }
};
