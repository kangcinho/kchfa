<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directors', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('directorID')->primary();
            $table->string('emitenDataID');
            $table->string('rasioID');
            $table->string('directorName');
            $table->decimal('ownershipEmiten', 14,2);
            $table->timestamps();

            $table->foreign('emitenDataID')->references('emitenDataID')->on('emiten_datas');
            $table->foreign('rasioID')->references('rasioID')->on('rasioes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directors');
    }
}
