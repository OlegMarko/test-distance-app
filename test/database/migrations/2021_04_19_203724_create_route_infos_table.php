<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('start');
            $table->unsignedBigInteger('end');
            $table->unsignedInteger('distance');
            $table->timestamps();

            $table->foreign('start')->references('id')->on('routes');
            $table->foreign('end')->references('id')->on('routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_infos');
    }
}
