<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InfoUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_number')->unique();
            $table->integer('coin')->default(0);
            $table->string('identify_numb', 12)->nullable($value = true);
            $table->string('phone', 15)->nullable($value = true)->unique();
            $table->string('region', 30)->nullable($value = true);
            $table->date('date_of_birth')->nullable($value = true);
            $table->integer('user_id')->unsigned()->unique();
            $table->tinyInteger('status');
            $table->bigInteger('telegram_id')->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_user');
    }
}