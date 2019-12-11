<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWajbaDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wajba_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wajba_id')->unsigned();
            $table->bigInteger('date_id')->unsigned();
            $table->foreign('wajba_id')->references('id')->on('wajbas')->onDelete('cascade');
            $table->foreign('date_id')->references('id')->on('dates')->onDelete('cascade');
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
        Schema::dropIfExists('wajba_dates');
    }
}
