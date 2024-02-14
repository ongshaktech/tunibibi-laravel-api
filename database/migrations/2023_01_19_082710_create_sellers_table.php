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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string("phone")->unique();
            $table->string("email")->nullable();
            $table->string("shop_name")->unique()->nullable();
            $table->integer("business_type_id")->nullable();
            $table->string("address")->nullable();
            $table->string("slug")->nullable();
            $table->string("logo")->nullable();
            $table->string("password")->nullable();
            $table->string("is_active")->default(1);
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
        Schema::dropIfExists('sellers');
    }
};
