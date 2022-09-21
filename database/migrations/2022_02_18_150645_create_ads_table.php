<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->uuid('ad_id')->unique();
            $table->foreignUuid('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->string('ticket_number')->unique();
            $table->string('travel_company');
            $table->string('departure');
            $table->string('destination');
            $table->date('departure_date');
            $table->date('arrival_date');
            $table->float('space');
            $table->json('categories_accepted');
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
        Schema::dropIfExists('ads');
    }
}
