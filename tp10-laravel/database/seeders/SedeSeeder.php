<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    public function run(): void
    {
        $sedes = [
            [
                'nombre' => 'Forja Centro',
                'direccion' => 'Av. Corrientes 1234, CABA',
                'horario_semana' => 'Lunes a Viernes: 06:00 - 23:00',
                'horario_sabado' => 'Sábados: 08:00 - 20:00',
            ],
            [
                'nombre' => 'Forja Norte',
                'direccion' => 'Av. Cabildo 2450, CABA',
                'horario_semana' => 'Lunes a Viernes: 06:00 - 23:00',
                'horario_sabado' => 'Sábados: 08:00 - 20:00',
            ],
            [
                'nombre' => 'Forja Sur',
                'direccion' => 'Av. Rivadavia 5678, CABA',
                'horario_semana' => 'Lunes a Viernes: 06:00 - 23:00',
                'horario_sabado' => 'Sábados: 08:00 - 20:00',
            ],
        ];

        foreach ($sedes as $sede) {
            Sede::updateOrCreate(['nombre' => $sede['nombre']], $sede);
        }
    }
}
