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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("number");
            $table->string("password");
            $table->string("country")->nullable();
            $table->string("email")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("postcode")->nullable();
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
        Schema::dropIfExists('buyers');
    }
};
