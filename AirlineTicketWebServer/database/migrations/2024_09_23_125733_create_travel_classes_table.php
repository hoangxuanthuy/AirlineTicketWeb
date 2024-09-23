<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelClassesTable extends Migration
{
    public function up()
    {
        Schema::create('Travel_Class', function (Blueprint $table) {
            $table->id('Travel_Class_ID'); // Auto-incrementing primary key
            $table->string('Travel_Class_Name');
            $table->integer('Travel_Class_Capacity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Travel_Class');
    }
}
