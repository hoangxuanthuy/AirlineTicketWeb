<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('ticket_id')->unique(); // Assuming ticket_id should be unique
            $table->foreignId('flight_id')->constrained()->onDelete('cascade'); // Foreign key reference to flights
            $table->string('seat_id'); // Seat identifier
            $table->string('luggage_id'); // Luggage identifier
            $table->string('status'); // Ticket status
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
