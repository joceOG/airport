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
            $table->uuid('package_id');
            $table->uuid('ad_id');
            $table->uuid('delivery_id')->unique();
            $table->string('status');
            $table->uuid('courier_id');
            $table->uuid('sender_id');
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
