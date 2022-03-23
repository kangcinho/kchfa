<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRasioesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rasioes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('rasioID')->primary();
            $table->string('rasioName');
            $table->text('note')->nullable();
            $table->boolean('isFinancial')->default(0);
            $table->boolean('isOwner')->default(0);
            $table->boolean('isNeraca')->default(0);
            $table->boolean('isLabaRugi')->default(0);
            $table->boolean('isCashFlow')->default(0);
            $table->boolean('isCFO')->default(0); //Menandakan Cash Flow Operation
            $table->boolean('isCFI')->default(0); //Menandakan Cash Flow Investment
            $table->boolean('isCFF')->default(0); //Menandakan Cash Flow Finance
            $table->boolean('isPBV')->default(0); //Menandakan Price Book Value :  Harga Saham / BVPS || Ekuitas / Jumlah Total Saham
            $table->boolean('isPER')->default(0); //Menandakan Price Earning Ratio : Harga Saham / EPS
            $table->boolean('isEPS')->default(0); //Menandakan Equity Per Share : Net Income / Jumlah Saham beredar
            $table->boolean('isROE')->default(0); //Menandakan Return on Equity : EPS / BVPS || Net Income / Equitas
            $table->boolean('isGPM')->default(0); //Menandakan Persentase Gross Profit terhadap Revenue
            $table->boolean('isNPM')->default(0); //Menandaka4n Persentase Net Profit terhadap Revenue
            $table->boolean('isDER')->default(0); //Menandakan Debt Equity (Hutang) : Total Liabilitas / Total Equitas
            $table->boolean('isTax')->default(0); // Menandakan Jumlah Pajak Sebelum dan Sesudah dibayarkan
            $table->boolean('isBVPS')->default(0); //Menandakan Book Value Per Share : Equitas / Jumlah Saham
            $table->boolean('isCurrentRatio')->default(0); //Menandakan Kemampuan Perusahan membayar hutang jangka pendek : Total Aset Lancar / Total Liabilitas Jangka Pendek
            $table->boolean('isQuickRatio')->default(0); //Menandakan Kemampuan Perusahan membayar hutang jangka pendek : (Total Aset Lancar - Persediaan) / Total Liabilitas Jangka Pendek
            $table->boolean('isNWC')->default(0); //Menandakan Kemampuan Perusahan membayar hutang jangka pendek : (Total Aset Lancar - Persediaan) / Total Liabilitas Jangka Pendek
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
        Schema::dropIfExists('rasioes');
    }
}
