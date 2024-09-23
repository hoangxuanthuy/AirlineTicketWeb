<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightServicesTable extends Migration
{
    public function up()
    {
        Schema::create('Flight_Service', function (Blueprint $table) {
            $table->id('Service_ID'); // Auto-incrementing primary key
            $table->string('Service_Name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Flight_Service');
    }
}
