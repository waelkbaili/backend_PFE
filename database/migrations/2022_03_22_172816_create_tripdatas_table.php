<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripdatas', function (Blueprint $table) {
            $table->id();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('speed')->nullable();
            $table->string('engine_rpm')->nullable();
            $table->string('engine_load')->nullable();
            $table->string('ambiant_temp')->nullable();
            $table->string('throttle_pos')->nullable();
            $table->string('inst_fuel')->nullable();
            $table->string('zone')->nullable();
            $table->string('place')->nullable();
            $table->string('sensor')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tripdatas');
    }
}
