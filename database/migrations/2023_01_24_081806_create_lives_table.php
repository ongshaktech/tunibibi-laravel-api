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
        Schema::create('lives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("seller_id");
            $table->string("title");
            $table->string("fb_rtmp")->nullable();
            $table->string("youtube_rtmp")->nullable();
            $table->json("products");
            $table->integer("is_ended")->default(0);
            $table->foreign("seller_id")->references("id")->on("sellers")->onDelete("cascade");
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
        Schema::dropIfExists('lives');
    }
};
