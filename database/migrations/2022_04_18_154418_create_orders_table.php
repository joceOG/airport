<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->uuid('order_id')->unique();
            $table->string('courier_email');
            $table->string('sender_email');
            $table->string('courier_phone');
            $table->string('sender_phone');
            $table->boolean('courier_whatsapp');
            $table->boolean('sender_whatsapp');
            $table->foreignUuid('package_id')->references('package_id')->on('packages')->onDelete('cascade');
            $table->foreignUuid('ad_id')->references('ad_id')->on('ads')->onDelete('cascade');
            $table->foreignUuid('delivery_id')->references('delivery_id')->on('deliveries')->onDelete('cascade');
            $table->string('status');
            $table->foreignUuid('courier_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreignUuid('sender_id')->references('user_id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
