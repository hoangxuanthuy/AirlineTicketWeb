<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    public function up()
    {
        Schema::create('Account', function (Blueprint $table) {
            $table->id('account_id');
            $table->string('email');
            $table->string('password');
            $table->string('account_name');
            $table->string('citizen_id');
            $table->string('phone');
        });

        Schema::create('Client', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('client_name');
            $table->string('citizen_id');
            $table->string('phone');
            $table->string('gender');
            $table->date('birth_day');
            $table->string('country');
        });

        Schema::create('Airline', function (Blueprint $table) {
            $table->id('airline_id');
            $table->string('airline_name');
        });

        Schema::create('Airport', function (Blueprint $table) {
            $table->id('id');
            $table->string('airport_name');
            $table->string('address');
        });

        Schema::create('Gate', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('airport_id')->constrained('Airport', 'id')->onDelete('cascade'); // Updated foreign key constraint
        });

        Schema::create('Plane', function (Blueprint $table) {
            $table->id('plane_id');
            $table->string('plane_name');
            $table->foreignId('airline_id')->constrained('Airline', 'airline_id'); // Updated foreign key constraint
            $table->integer('first_class_seats');
            $table->integer('second_class_seats');
        });

        Schema::create('SeatClass', function (Blueprint $table) {
            $table->id('seat_class_id');
            $table->string('seat_class_name');
            $table->float('price_ratio');
        });

        Schema::create('Seat', function (Blueprint $table) {
            $table->id('seat_id');
            $table->foreignId('seat_class_id')->constrained('SeatClass', 'seat_class_id'); // Updated foreign key constraint
            $table->foreignId('plane_id')->constrained('Plane', 'plane_id'); // Updated foreign key constraint
        });

        Schema::create('Flight', function (Blueprint $table) {
            $table->id('flight_id');
            $table->foreignId('plane_id')->constrained('Plane', 'plane_id'); // Updated foreign key constraint
            $table->foreignId('departure_airport_id')->constrained('Airport', 'id'); // Updated foreign key constraint
            $table->foreignId('arrival_airport_id')->constrained('Airport', 'id'); // Updated foreign key constraint
            $table->foreignId('gate_id')->constrained('Gate', 'id'); // Updated foreign key constraint
            $table->time('flight_time');
            $table->dateTime('departure_date_time');
            $table->float('unit_price');
        });

        Schema::create('Intermediate', function (Blueprint $table) {
            $table->foreignId('flight_id')->constrained('Flight', 'flight_id'); // Updated foreign key constraint
            $table->foreignId('intermediate_airport_id')->constrained('Airport', 'id'); // Updated foreign key constraint
            $table->time('stopover_time');
            $table->string('note')->nullable();
            $table->primary(['flight_id', 'intermediate_airport_id']);
        });

        Schema::create('Luggage', function (Blueprint $table) {
            $table->id('luggage_id');
            $table->float('weight');
            $table->float('price');
        });

        Schema::create('Promotion', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->string('promotion_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->float('discount_percentage');
        });

        Schema::create('Booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('seat_id')->constrained('Seat', 'seat_id'); // Updated foreign key constraint
            $table->foreignId('flight_id')->constrained('Flight', 'flight_id'); // Updated foreign key constraint
            $table->foreignId('client_id')->constrained('Client', 'client_id'); // Updated foreign key constraint
            $table->foreignId('luggage_id')->constrained('Luggage', 'luggage_id'); // Updated foreign key constraint
            $table->foreignId('promotion_id')->constrained('Promotion', 'promotion_id'); // Updated foreign key constraint
            $table->string('status');
            $table->date('booking_issuance_date');
        });

        Schema::create('Ticket', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->foreignId('seat_id')->constrained('Seat', 'seat_id'); // Updated foreign key constraint
            $table->foreignId('promotion_id')->constrained('Promotion', 'promotion_id'); // Updated foreign key constraint
            $table->foreignId('client_id')->constrained('Client', 'client_id'); // Updated foreign key constraint
            $table->foreignId('luggage_id')->constrained('Luggage', 'luggage_id'); // Updated foreign key constraint
            $table->foreignId('flight_id')->constrained('Flight', 'flight_id'); // Updated foreign key constraint
            $table->date('ticket_issuance_date');
            $table->string('status');
        });

        Schema::create('SeatFlight', function (Blueprint $table) {
            $table->foreignId('seat_id')->constrained('Seat', 'seat_id'); // Updated foreign key constraint
            $table->foreignId('flight_id')->constrained('Flight', 'flight_id'); // Updated foreign key constraint
            $table->string('status');
            $table->primary(['seat_id', 'flight_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('SeatFlight');
        Schema::dropIfExists('Ticket');
        Schema::dropIfExists('Booking');
        Schema::dropIfExists('Promotion');
        Schema::dropIfExists('Luggage');
        Schema::dropIfExists('Intermediate');
        Schema::dropIfExists('Flight');
        Schema::dropIfExists('Seat');
        Schema::dropIfExists('SeatClass');
        Schema::dropIfExists('Plane');
        Schema::dropIfExists('Gate');
        Schema::dropIfExists('Airport');
        Schema::dropIfExists('Airline');
        Schema::dropIfExists('Client');
        Schema::dropIfExists('Account');
    }
}