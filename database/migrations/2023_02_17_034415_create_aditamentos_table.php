<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAditamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aditamentos', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->foreignId('aditamento_id')->nullable()->constrained('productos');
            $table->foreignId('numero_producto')->default(1);
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
        Schema::dropIfExists('aditamentos');
    }
}
