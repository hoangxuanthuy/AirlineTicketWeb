<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('Seat_Details', function (Blueprint $table) {
            $table->id('Seat_ID'); // Auto-incrementing primary key
            $table->unsignedBigInteger('Travel_Class_ID');
            $table->unsignedBigInteger('Flight_ID');

            $table->foreign('Travel_Class_ID')->references('Travel_Class_ID')->on('Travel_Class');
            $table->foreign('Flight_ID')->references('Flight_ID')->on('flight_details'); // Ensure the table name matches
        });
    }

    public function down()
    {
        Schema::dropIfExists('Seat_Details');
    }
}
