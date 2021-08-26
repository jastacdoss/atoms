<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WaterfallTable extends Migration
{
    public function up()
    {
        Schema::create('waterfall', function (Blueprint $table) {

            $table->increments('id');
            $table->string('service_area',7);
            $table->string('district',13);
            $table->string('facility_type',27);
            $table->decimal('level',38,0);
            $table->string('facility_id',3);
            $table->string('facility_name',31);
            $table->integer('areas-opereational');
            $table->integer('areas-tmu');
            $table->string('enroute-terminal',2);
            $table->string('hr_region',2);
            $table->boolean('core_airport');
            $table->string('piv_readers',5);
            $table->decimal('bues',38,0);
            $table->boolean('has_wmt');
            $table->boolean('has_preflex');
            $table->boolean('has_postflex');
            $table->boolean('has_siso');
            $table->boolean('has_opq');
            $table->integer('release');
            $table->integer('release_adjusted');
            $table->string('key_site',7);
            $table->date('key_site_start')->nullable();
            $table->decimal('deployment_priority',38,0);
            $table->date('training_date');
            $table->string('training_team',6);
            $table->date('training_start_date');
            $table->date('go_live_date');

        });
    }

    public function down()
    {
        Schema::dropIfExists('waterfall');
    }
}
