<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FacilityAddress extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facility_id',7);
            $table->string('address');
            $table->string('address2');
            $table->string('city',20);
            $table->string('state',3);
            $table->string('zip',10);
            $table->string('phone',14);
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
