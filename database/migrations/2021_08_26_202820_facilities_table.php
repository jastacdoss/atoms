<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WaterfallTable extends Migration
{
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {

            $table->increments('id');
            $table->string('service_area',7);
            $table->string('district',13);
            $table->string('facility_type',27);
            $table->decimal('level',38,0);
            $table->string('facility_id',3);
            $table->string('facility_name',31);
            $table->integer('areas_operational');
            $table->integer('areas_tmu');
            $table->string('enroute_terminal',2);
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
            $table->string('training_facility');
            $table->unsignedInteger('team_id');
            $table->date('training_start_date');
            $table->date('go_live_date');
            $table->tinyInteger('sibling_status')->default(0); // 0 - NO, 1 - RADIUS, 2 - DISTANCE

        });
    }

    public function down()
    {
        Schema::dropIfExists('facilities');
    }
}
