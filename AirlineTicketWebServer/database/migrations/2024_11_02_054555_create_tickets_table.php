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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->foreignId('flight_id')->constrained('flights', 'flight_id');
            $table->foreignId('account_id')->constrained('accounts', 'account_id');
            $table->foreignId('class_id')->constrained('seat_classes', 'class_id');
            $table->foreignId('promotion_id')->nullable()->constrained('promotions', 'promotion_id');
            $table->timestamp('issue_date')->nullable();
            $table->string('status');
            $table->foreignId('luggage_id')->nullable()->constrained('luggages', 'luggage_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
