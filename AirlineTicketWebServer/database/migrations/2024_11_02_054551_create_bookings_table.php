<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('aircraft_id')->constrained('aircrafts', 'aircraft_id');
            $table->foreignId('departure_airport_id')->constrained('airports', 'airport_id');
            $table->foreignId('destination_airport_id')->constrained('airports', 'airport_id');
           // $table->foreignId('port_id')->constrained('flight_gates');
            $table->json('flight_times');
            $table->timestamp('start_flight_time');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
