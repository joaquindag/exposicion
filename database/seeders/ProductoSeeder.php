<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            "nombre"=> "PC",
            "precio"=>200,
            "descripcion"=>"El ordenador mas bonito que veras"
        ]);

        Producto::create([
            "nombre"=> "radio",
            "precio"=>200,
            "descripcion"=>"Una radio normal y corriente"
        ]);
    }
}
