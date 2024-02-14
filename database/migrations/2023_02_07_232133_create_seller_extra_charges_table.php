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
        Schema::create('seller_extra_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->unsignedBigInteger("extra_charge_id");
            $table->unsignedBigInteger("catagory_id");
            $table->double("charge_amount");
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("cascade");
            $table->foreign("catagory_id")->references("id")->on("catagory")->onDelete("cascade");
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
        Schema::dropIfExists('seller_extra_charges');
    }
};
