<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_mantenimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idmantenimiento')->unsigned(); 
            $table->foreign('idmantenimiento')->references('id')->on('mantenimientos')->onDelete('cascade');
            $table->integer('idinsumo')->unsigned();
            $table->foreign('idinsumo')->references('id')->on('insumos');
            $table->integer('cantidad');
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_mantenimientos');
    }
}
