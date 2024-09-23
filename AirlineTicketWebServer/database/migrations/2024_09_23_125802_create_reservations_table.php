<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('Reservation', function (Blueprint $table) {
            $table->id('Reservation_ID'); // Auto-incrementing primary key
            $table->unsignedBigInteger('Passenger_ID');
            $table->unsignedBigInteger('Seat_ID');
            $table->timestamp('Date_Of_Reservation');

            $table->foreign('Passenger_ID')->references('Passenger_ID')->on('Passenger');
            $table->foreign('Seat_ID')->references('Seat_ID')->on('Seat_Details');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Reservation');
    }
}
