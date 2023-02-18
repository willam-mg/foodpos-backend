<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('restaurante', 45);
            $table->string('nombre_punto_venta', 45);
            $table->string('foto', 100);
            $table->text('direccion');
            $table->string('telefono', 45);
            $table->string('telefono_pedidos', 45);
            $table->time('hora_apertura')->comment('inicio de hora de atencion');
            $table->time('hora_cierre')->comment('fin de hora de atencion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punto_ventas');
    }
}
