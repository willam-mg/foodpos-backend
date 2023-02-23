<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->text('descripcion');
            $table->string('src_foto', 100)->nullable();
            $table->decimal('precio', 10, 2);
            $table->smallInteger('precio_x_gr')->default(0)->comment('para obtener el precio subotal  por cantidad o gramos');
            $table->smallInteger('es_producto')->default(1)->comment('0 = No, 1 = Si');
            $table->smallInteger('es_aditamento')->default(0)->comment('0 = No, 1 = Si');
            $table->smallInteger('publicado')->default(1)->comment('0 = No, 1 = Si');
            $table->foreignId('punto_venta_id')->nullable()->constrained('punto_ventas');
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
