<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightCostsTable extends Migration
{
    public function up()
    {
        Schema::create('Flight_Cost', function (Blueprint $table) {
            $table->unsignedBigInteger('Seat_ID'); // Ensure this matches the type in SeatDetails
            $table->date('Valid_From_Date'); // Ensure this matches the type in Calendar
            $table->date('Valid_To_Date');
            $table->decimal('Cost', 10, 2);
    
            // Define foreign key constraints
            $table->foreign('Seat_ID')->references('Seat_ID')->on('Seat_Details')->onDelete('cascade');
            $table->foreign('Valid_From_Date')->references('Day_Date')->on('Calendar')->onDelete('cascade');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('Flight_Cost');
    }
}
