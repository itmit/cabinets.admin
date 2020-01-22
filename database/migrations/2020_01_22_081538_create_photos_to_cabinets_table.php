<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosToCabinetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos_to_cabinets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cabinet_id')->unsigned();
            $table->string('photo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cabinet_id')->references('id')->on('cabinets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos_to_cabinets');
    }
}
