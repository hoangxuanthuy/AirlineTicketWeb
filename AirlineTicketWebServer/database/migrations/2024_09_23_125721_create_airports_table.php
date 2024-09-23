<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{ public function up()
    {
        Schema::create('Airport', function (Blueprint $table) {
            $table->id('Airport_ID'); // This makes Airport_ID auto-incrementing
            $table->string('AirportName');
            $table->string('AirportCity');
            $table->string('AirportCountry');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Airport');
    }
}
