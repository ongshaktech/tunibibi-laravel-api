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
        Schema::table('wirehouses', function (Blueprint $table) {
            $table->string("number");
            $table->string("city");
            $table->string("postcode");
            $table->string("password");
            $table->string("payment_method")->default("COD");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wirehouses', function (Blueprint $table) {
            //
        });
    }
};
