<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wajba_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(2);
            $table->integer('numberOfFemales')->default(0);
            $table->integer('numberOfMales')->default(0);
            $table->integer('numberOfChildren')->default(0);
            $table->double('totalAmount', 10);
            $table->integer('is_rated')->default(0);
            $table->bigInteger('date_id')->unsigned();
            // $table->bigInteger('time_id')->unsigned();
            $table->foreign('wajba_id')->references('id')->on('wajbas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            // $table->foreign('time_id')->references('id')->on('times')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
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
        Schema::dropIfExists('bookings');
    }
}
