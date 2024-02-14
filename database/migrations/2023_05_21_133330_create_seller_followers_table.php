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
        Schema::create('seller_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->unsignedBigInteger("buyer_id");
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("CASCADE");
            $table->foreign("buyer_id")->references("id")->on("buyers")->onDelete("CASCADE");
            $table->timestamp("created_at")->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamp("updated_at")->default(DB::raw("CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_flowers');
    }
};
