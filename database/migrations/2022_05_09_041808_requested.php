<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Requested extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('email');
            $table->text('identify_numb');
            $table->date('buy_coin_1');
            $table->integer('price_1');
            $table->date('buy_coin_2');
            $table->integer('price_2');
            $table->date('buy_coin_3');
            $table->integer('price_3');
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
        Schema::dropIfExists('requested');
    }
}