<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    public function up()
    {
        Schema::create('Calendar', function (Blueprint $table) {
            $table->date('Day_Date')->primary(); // Setting Day_Date as primary key
            $table->boolean('Business_Day_YN'); // Example for business day
        });
    }

    public function down()
    {
        Schema::dropIfExists('Calendar');
    }
}
