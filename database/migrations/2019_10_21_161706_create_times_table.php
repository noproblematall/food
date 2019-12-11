<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wajba_id')->unsigned();
            // $table->bigInteger('date_id')->unsigned();
            // $table->foreign('date_id')->references('id')->on('dates')->onDelete('cascade');
            // $table->bigInteger('wajba_date_id')->unsigned();
            // $table->foreign('wajba_date_id')->references('id')->on('wajba_dates')->onDelete('cascade');
            $table->string('fromTime', 255);
            $table->string('toTime', 255);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('times');
    }
}
