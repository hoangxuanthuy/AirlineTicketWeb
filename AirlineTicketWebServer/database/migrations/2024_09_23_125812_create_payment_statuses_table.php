<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('Payment_Status', function (Blueprint $table) {
            $table->id('Status_ID'); // Auto-incrementing primary key
            $table->string('Status_Name'); // Example attribute
        });
    }

    public function down()
    {
        Schema::dropIfExists('Payment_Status');
    }
}
