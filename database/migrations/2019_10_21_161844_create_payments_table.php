<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->bigInteger('booking_id')->unsigned();
            // $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            // $table->double('totalAmount', 10, 2);
            $table->boolean('status')->default(false);
            $table->string('paymentRef')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
