<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCabinetReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabinet_reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cabinet_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->date('date');
            $table->string('time');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cabinet_id')->references('id')->on('cabinets');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cabinet_reservations');
    }
}
