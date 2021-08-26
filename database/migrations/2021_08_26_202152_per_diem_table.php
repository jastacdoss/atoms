<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PerDiemTable extends Migration
{
    public function up()
    {
        Schema::create('perdiem', function (Blueprint $table) {
            $table->increments('id',);
            $table->decimal('destination_id',38,0);
            $table->string('name',44);
            $table->string('location',191);
            $table->string('state',2);
            $table->decimal('zip',38,0);
            $table->year('fiscal');
            $table->decimal('oct',38,0);
            $table->decimal('nov',38,0);
            $table->decimal('dec',38,0);
            $table->decimal('jan',38,0);
            $table->decimal('feb',38,0);
            $table->decimal('mar',38,0);
            $table->decimal('apr',38,0);
            $table->decimal('may',38,0);
            $table->decimal('jun',38,0);
            $table->decimal('jul',38,0);
            $table->decimal('aug',38,0);
            $table->decimal('sep',38,0);
            $table->decimal('meals',38,0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('perdiem');
    }
}
