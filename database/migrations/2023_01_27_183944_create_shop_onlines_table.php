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
        Schema::create('shop_onlines', function (Blueprint $table) {
            $table->id();
            $table->integer("shop_id");
            $table->time("from_time");
            $table->time("to_time")->nullable();
            $table->date("from_date");
            $table->date("to_date")->nullable();
            $table->integer("is_active")->default(1);
            $table->date("date")->default(\Illuminate\Support\Facades\Date::now());
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
        Schema::dropIfExists('shop_onlines');
    }
};
