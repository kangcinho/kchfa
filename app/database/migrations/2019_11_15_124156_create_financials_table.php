<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('financialID')->primary();
            $table->string('emitenDataID')->index();
            $table->string('rasioID');
            $table->string('currencyID');
            $table->decimal('pricePerUnitCurrency',14,2);
            $table->decimal('price', 14,2);
            $table->timestamps();

            $table->foreign('emitenDataID')->references('emitenDataID')->on('emiten_datas');
            $table->foreign('rasioID')->references('rasioID')->on('rasioes');
            $table->foreign('currencyID')->references('currencyID')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financials');
    }
}
