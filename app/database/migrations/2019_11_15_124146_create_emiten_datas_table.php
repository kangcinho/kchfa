<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmitenDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emiten_datas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('emitenDataID')->primary();
            $table->string('emitenID');
            $table->string('quartalID');
            $table->decimal('emitenPrice', 14,2);
            $table->string('yearID');
            $table->boolean('isAktif');
            $table->timestamps();

            $table->foreign('emitenID')->references('emitenID')->on("emitens");
            $table->foreign('quartalID')->references('quartalID')->on("quartals");
            $table->foreign('yearID')->references('yearID')->on("years");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emiten_datas');
    }
}
