<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('plane_id');
            $table->string('start_airport_id');
            $table->string('end_airport_id');
            $table->timestamp('time_start')->nullable();
            $table->timestamp('time_end')->nullable(); // Allow NULL values
            $table->float('flight_time');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
