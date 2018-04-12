<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Plans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('gateway_id');
            $table->string('gateway_name');
            $table->string('currency');
            $table->boolean('is_default')->default(false);
            $table->string('interval')->default('MONTHLY');
            $table->integer('trial_days')->default(0);
            $table->decimal('recurring_price', 18, 2)->default(0);
            $table->decimal('first_charge', 18, 2)->default(0);
            $table->decimal('trial_charge', 18, 2)->default(0); // first charge if has trial period
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
        Schema::dropIfExists('plans');
    }
}
