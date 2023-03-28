<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categoria_productos')->insert([
            'nombre' => 'Ensalada',
        ]);
        DB::table('categoria_productos')->insert([
            'nombre' => 'Amburguesas',
        ]);
        DB::table('categoria_productos')->insert([
            'nombre' => 'Helados',
        ]);
        DB::table('categoria_productos')->insert([
            'nombre' => 'Bebidas extra',
        ]);
        DB::table('categoria_productos')->insert([
            'nombre' => 'Jugos',
        ]);
        DB::table('categoria_productos')->insert([
            'nombre' => 'Falsos',
        ]);
    }
}
