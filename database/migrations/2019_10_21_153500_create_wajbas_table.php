<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWajbasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wajbas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('host_id')->unsigned();
            $table->foreign('host_id')->references('id')->on('hosts')->onDelete('cascade');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->integer('place_category_id')->unsigned();
            $table->foreign('place_category_id')->references('id')->on('place_categories')->onDelete('cascade');
            $table->integer('food_category_id')->unsigned();
            $table->foreign('food_category_id')->references('id')->on('food_categories')->onDelete('cascade');
            $table->string('title');
            $table->float('price', 10);
            $table->mediumText('description');
            $table->enum('door_type', ['out_door', 'in_door']);
            $table->string('healthConditionsAndWarnings', 500)->nullable();
            $table->string('city', 255);
            $table->string('city_name', 255)->nullable();
            $table->float('totalRate', 10)->nullable();
            $table->float('latitude', 10, 2);
            $table->float('longitude', 10, 2);
            $table->integer('baseNumberOfSeats')->nullable();
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
        Schema::dropIfExists('wajbas');
    }
}
