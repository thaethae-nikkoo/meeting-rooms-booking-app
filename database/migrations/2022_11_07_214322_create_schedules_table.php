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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->String('duration');
            $table->String('topic');
            $table->String('booking_person_name');
            $table->String('email');
            $table->String('phone');
            $table->text('link')->nullable();
            $table->text('notes')->nullable();
            $table->String('status');
            $table->String('reason')->nullable();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
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
        Schema::dropIfExists('schedules');
    }
};
