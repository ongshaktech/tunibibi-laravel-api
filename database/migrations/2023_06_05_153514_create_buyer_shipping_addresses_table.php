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
        Schema::create('buyer_shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->string("name1");
            $table->string("name2")->nullable();
            $table->string("mobile");
            $table->string("street");
            $table->string("apartment")->nullable();
            $table->string("country");
            $table->string("state");
            $table->string("city");
            $table->string("zip");
            $table->integer("is_default")->default(0);
            $table->unsignedBigInteger("buyer_id");
            $table->foreign("buyer_id")->references("id")->on("buyers")->onDelete("cascade");
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
        Schema::dropIfExists('buyer_shipping_addresses');
    }
};
