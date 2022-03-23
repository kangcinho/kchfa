<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmitensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emitens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('emitenID')->primary();
            $table->string('emitenKode')->index();
            $table->string('emitenName')->index();
            $table->text('emitenAddress')->nullable();
            $table->text('emitenInfo')->nullable();
            $table->string('subSectorID');
            $table->decimal('amountShare',14,2);
            $table->boolean('isBUMN')->default(0);
            $table->boolean('isAktif')->default(0);
            $table->timestamps();

            $table->foreign('subSectorID')->references('subSectorID')->on('sub_sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emitens');
    }
}
