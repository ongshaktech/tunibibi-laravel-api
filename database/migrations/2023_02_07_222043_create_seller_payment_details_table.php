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
        Schema::create('seller_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->integer("method_id")->unsigned();
            $table->string("method_details")->nullable();
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
        Schema::dropIfExists('seller_payment_details');
    }
};
