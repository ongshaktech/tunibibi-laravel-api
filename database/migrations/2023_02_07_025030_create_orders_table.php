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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer("buyer_id");
            $table->integer("seller_id");
            $table->string("order_id");
            $table->integer("product_id");
            $table->integer("quantity");
            $table->json("wholesale_info");
            $table->json("varient_info");
            $table->json("coupon_info")->nullable();
            $table->double("product_price")->nullable();
            $table->double("amount")->nullable();
            $table->double("disc_amount")->nullable();
            $table->json("shipping_info")->nullable();
            $table->double("shipping_charge")->nullable();
            $table->double("delivery_charge")->nullable();
            $table->json("buyer_shipping_addresses_info")->nullable();
            $table->integer("wirehouse_id")->nullable();
            $table->string("order_status_seller")->default("Pending");
            $table->string("delivery_time")->nullable();
            $table->string("delivery_payment_status")->default("unpaid");
            $table->string("payment_status")->default("unpaid");
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
        Schema::dropIfExists('orders');
    }
};
