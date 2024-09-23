<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    public function up()
    {
        Schema::create('Passenger', function (Blueprint $table) {
            $table->id('Passenger_ID'); // Auto-incrementing primary key
            $table->string('P_FirstName');
            $table->string('P_LastName');
            $table->string('P_Email')->unique(); // Consider adding uniqueness
            $table->string('P_PhoneNumber')->nullable();
            $table->string('P_Address')->nullable();
            $table->string('P_City')->nullable();
            $table->string('P_State')->nullable();
            $table->string('P_Zipcode')->nullable();
            $table->string('P_Country')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Passenger');
    }
}
