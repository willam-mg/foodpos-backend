<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_producto');
            $table->smallInteger('precio_x_gr')->default(0)->comment('para obtener el precio subotal  por cantidad o gramos');
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad');
            $table->decimal('descuento', 10, 2)->comment('monto a descontar');
            $table->decimal('gramos', 10, 2)->nullable();
            $table->foreignId('venta_id')->constrained('ventas');
            $table->foreignId('producto_id')->constrained('productos');
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
        Schema::dropIfExists('detalle_ventas');
    }
}
