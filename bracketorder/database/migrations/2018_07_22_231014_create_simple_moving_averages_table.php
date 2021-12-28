<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimpleMovingAveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_moving_averages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('sma_number_1')->nullable();
            $table->integer('periods_1')->nullable();
            $table->string('color_1')->nullable();
            $table->string('sma_number_2')->nullable();
            $table->integer('periods_2')->nullable();
            $table->string('color_2')->nullable();
            $table->string('sma_number_3')->nullable();
            $table->integer('periods_3')->nullable();
            $table->string('color_3')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simple_moving_averages');
    }
}
