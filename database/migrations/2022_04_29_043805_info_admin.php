<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InfoAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 15)->nullable($value = true)->unique();
            $table->integer('user_id')->unsigned()->unique();
            $table->bigInteger('telegram_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_admin');
    }
}
