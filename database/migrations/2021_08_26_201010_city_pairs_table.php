<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration from create table statement!!
 * https://laravelarticle.com/laravel-migration-generator-online
 */

class CityPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_pairs', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('AWARD_YEAR',38,0);
            $table->string('FROM',3);
            $table->string('TO',3);
            $table->string('ORIGIN_CITY_NAME',21);
            $table->string('ORIGIN_STATE',2);
            $table->string('ORIGIN_COUNTRY',4);
            $table->string('DESTINATION_CITY_NAME',22);
            $table->string('DESTINATION_STATE',2);
            $table->string('DESTINATION_COUNTRY',20);
            $table->string('AIRLINE_ABBREV',2);
            $table->string('AWARDED_SERV',1);
            $table->decimal('PAX_COUNT',38,0);
            $table->decimal('YCA_FARE',38,0);
            $table->decimal('XCA_FARE',38,0);
            $table->decimal('BUSINESS_FARE',38,0);
            $table->string('ORIGIN_AIRPORT_LOCATION',39);
            $table->string('DESTINATION_AIRPORT_LOCATION',34);
            $table->string('ORIGIN_CITY_STATE_AIRPORT',27);
            $table->string('DESTINATION_CITY_STATE_AIRPORT',27);
            $table->date('EFFECTIVE_DATE');
            $table->date('EXPIRATION_DATE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_pairs');
    }
}
