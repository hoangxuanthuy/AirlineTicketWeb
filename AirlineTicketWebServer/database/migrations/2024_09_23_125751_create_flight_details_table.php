<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('flight_details', function (Blueprint $table) {
            $table->id('Flight_ID'); // Auto-incrementing primary key
            $table->unsignedBigInteger('Source_Airport_ID'); // Use unsignedBigInteger for foreign keys
            $table->unsignedBigInteger('Destination_Airport_ID');
            $table->dateTime('Departure_Date_Time');
            $table->dateTime('Arrival_Date_Time');
            $table->string('Airplane_Type');
    
            // Add foreign key constraints
            $table->foreign('Source_Airport_ID')->references('Airport_ID')->on('airport')->onDelete('cascade');
            $table->foreign('Destination_Airport_ID')->references('Airport_ID')->on('airport')->onDelete('cascade');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('flight_details');
    }
}
