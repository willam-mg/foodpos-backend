<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAditamentoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aditamento_ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_producto')->default(1);
            $table->foreignId('detalle_venta_id')->constrained('detalle_ventas');
            $table->foreignId('aditamento_id')->constrained('aditamentos');
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
        Schema::dropIfExists('aditamento_ventas');
    }
}
