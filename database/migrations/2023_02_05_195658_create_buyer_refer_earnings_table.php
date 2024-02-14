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
        Schema::create('buyer_refer_earnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("buyer_id");
            $table->integer("coins");
            $table->string("refer_user_type");
            $table->unsignedBigInteger("refered_buyer_id")->nullable();
            $table->foreign("refered_buyer_id")->references("id")->on("buyers")->onDelete("cascade");
            $table->foreign("buyer_id")->references("id")->on("buyers")->onDelete("cascade");
            $table->timestamp("created_at")->default(\Illuminate\Support\Facades\DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamp("updated_at")->default(\Illuminate\Support\Facades\DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_refer_earnings');
    }
};
