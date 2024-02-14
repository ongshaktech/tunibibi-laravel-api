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
        Schema::table('buy_togethers', function (Blueprint $table) {
            $table->unsignedBigInteger("product_varient_id")->nullable();
            $table->json("size")->nullable();
            $table->foreign("product_varient_id")->references("id")->on("product_varients")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buy_togethers', function (Blueprint $table) {
            //
        });
    }
};
