<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntoVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('punto_ventas')->insert([
            'restaurante' => 'Fit Food',
            'nombre_punto_venta' => 'Fit Food',
            'src_foto' => 'fitfood.png',
            'direccion' => 'Av. Abraham Lincoln, Esquina Calle Finod, Cochabamba',
            'telefono' => '76474988',
            'telefono_pedidos' => '76474988',
            'hora_apertura' => '10:00',
            'hora_cierre' => '22:00',
        ]);
        
        DB::table('punto_ventas')->insert([
            'restaurante' => 'Mamá Vicenta',
            'nombre_punto_venta' => 'Mamá Vicenta',
            'src_foto' => 'mamavicenta.png',
            'direccion' => 'Av. Abraham Lincoln, Esquina Calle Finod, Cochabamba',
            'telefono' => '76474988',
            'telefono_pedidos' => '76474988',
            'hora_apertura' => '10:00',
            'hora_cierre' => '22:00',
        ]);
    }
}
