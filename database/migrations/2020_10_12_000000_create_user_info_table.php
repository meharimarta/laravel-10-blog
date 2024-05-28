<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('about',500)->nullable();
            $table->string('skill',100)->nullable();
            $table->string('cover_image',255)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->text('fb')->nullable();
            $table->text('tg')->nullable();
            $table->text('yb')->nullable();
            $table->text('twt')->nullable();
            $table->string('phone')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
}
