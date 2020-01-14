<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('auction_id');
            $table->char('vin', 17);
            $table->string('make');
            $table->string('model');
            $table->string('style')->nullable();
            $table->unsignedInteger('year');
            $table->integer('seats')->nullable();
            $table->integer('doors')->nullable();
            $table->string('engine')->nullable();
            $table->string('transmission')->nullable();
            $table->enum('body', [
                'convertible',
                'truck',
                'van',
                'wagon',
                'suv',
                'coupe',
                'sedan',
                'crossover',
                'minivan',
                'truck_crew_cab',
                'truck_extended_cab',
                'truck_long_regular_cab',
                'motorcycle',
                'cargo_van',
                'commercial',
                'trailer',
                'hatchback',
            ])->nullable();
            $table->string('interior_color')->nullable();
            $table->string('exterior_color')->nullable();
            $table->unsignedInteger('odometer');
            $table->timestamps();

            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
