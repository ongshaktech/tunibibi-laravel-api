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
        Schema::create('seller_recharge_requests', function (Blueprint $table) {
            $table->id();
            $table->integer("seller_id")->unsigned();
            $table->string("country_name");
            $table->string("code");
            $table->string("operator");
            $table->string("mobile_no");
            $table->integer("amount");
            $table->string("status")->default("pending");
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
        Schema::dropIfExists('seller_recharge_requests');
    }
};
