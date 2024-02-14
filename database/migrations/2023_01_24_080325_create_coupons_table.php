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

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string("seller_id");
            $table->string("coupon_code")->nullable();
            $table->integer("usage_per_customer")->default(1);
            $table->string("discount_type")->nullable();
            $table->integer("discount_value")->nullable();
            $table->integer("min_qty")->nullable();
            $table->integer("min_order_amount")->nullable();
            $table->integer("max_disc_amount")->nullable();
            $table->string("show_to_customer")->default(0);
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
        Schema::dropIfExists('coupons');
    }
};
