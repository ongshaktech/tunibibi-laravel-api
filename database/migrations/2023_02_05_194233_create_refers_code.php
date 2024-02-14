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
        Schema::create('refers_code', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id")->nullable();
            $table->unsignedBigInteger("buyer_id")->nullable();
            $table->string("code");
            $table->string("user_type");
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("cascade");
            $table->foreign("buyer_id")->references("id")->on("buyers")->onDelete("cascade");
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
        Schema::dropIfExists('refers_code');
    }
};
