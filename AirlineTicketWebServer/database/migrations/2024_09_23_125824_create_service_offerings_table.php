<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOfferingsTable extends Migration
{
    public function up()
    {
        Schema::create('Service_Offering', function (Blueprint $table) {
            $table->unsignedBigInteger('Travel_Class_ID');
            $table->unsignedBigInteger('Service_ID');
            $table->boolean('Offered_YN');
            $table->string('From_Month')->nullable();
            $table->string('To_Month')->nullable();
            $table->primary(['Travel_Class_ID', 'Service_ID']); // Composite primary key

            $table->foreign('Travel_Class_ID')->references('Travel_Class_ID')->on('Travel_Class');
            $table->foreign('Service_ID')->references('Service_ID')->on('Flight_Service');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Service_Offering');
    }
}
