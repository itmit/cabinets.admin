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
            $table->uuid('uuid');
            $table->bigInteger('cabinet_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->date('date');
            $table->integer('total_amount')->unsigned()->default(0);
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_cancel')->default(0);
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
