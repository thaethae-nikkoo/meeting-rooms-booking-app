<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_slot2s', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id')->nullable();
            $table->String('date')->nullable();
            $table->String('start_time')->nullable();
            $table->String('unavailable_slots')->nullable();
            $table->String('status')->nullable();
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
        Schema::dropIfExists('group_slot2s');
    }
};
