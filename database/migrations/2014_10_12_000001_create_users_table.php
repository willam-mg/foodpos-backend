<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('src_foto', 100)->nullable();
            $table->enum('turno', [
                    'Administrativo',
                    'Mañana',
                    'Tarde',
                    'Noche',
                    'Mañana y tarde',
                    'tarde y noche', 
                    'Mañana, tarde y noche'
                ])->default('Administrativo')->nullable();
            $table->smallInteger('role')->default(2)->comment('2 = administrador, 3 = vendedor');
            $table->smallInteger('estado')->default(2)->comment('2 = activo, 3 = bloqueado');
            $table->foreignId('punto_venta_id')->nullable()->constrained('punto_ventas');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
