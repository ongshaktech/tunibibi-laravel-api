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
        Schema::create('buyer_favourite_names', function (Blueprint $table) {
            $table->id();
            $table->string("name");
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
        Schema::dropIfExists('buyer_favourite_names');
    }
};
