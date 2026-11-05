<?php

namespace Tests\Feature;

use App\Models\Sede;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SedeTest extends TestCase
{
    use RefreshDatabase;

    public function test_lista_las_sedes(): void
    {
        $this->crearSede('Forja Centro');

        $this->get('/sedes')
            ->assertOk()
            ->assertSee('Forja Centro');
    }

    public function test_crea_una_sede(): void
    {
        $this->post('/sedes', $this->datos('Forja Oeste'))
            ->assertRedirect('/sedes');

        $this->assertDatabaseHas('sedes', ['nombre' => 'Forja Oeste']);
    }

    public function test_no_permite_nombres_duplicados(): void
    {
        $this->crearSede('Forja Centro');

        $this->post('/sedes', $this->datos('Forja Centro'))
            ->assertSessionHasErrors('nombre');

        $this->assertDatabaseCount('sedes', 1);
    }

    public function test_actualiza_una_sede(): void
    {
        $sede = $this->crearSede('Forja Centro');

        $this->put("/sedes/{$sede->id}", $this->datos('Forja Centro Renovada'))
            ->assertRedirect('/sedes');

        $this->assertDatabaseHas('sedes', ['id' => $sede->id, 'nombre' => 'Forja Centro Renovada']);
    }

    public function test_elimina_una_sede(): void
    {
        $sede = $this->crearSede('Forja Centro');

        $this->delete("/sedes/{$sede->id}")
            ->assertRedirect('/sedes');

        $this->assertDatabaseMissing('sedes', ['id' => $sede->id]);
    }

    private function crearSede(string $nombre): Sede
    {
        return Sede::create($this->datos($nombre));
    }

    private function datos(string $nombre): array
    {
        return [
            'nombre' => $nombre,
            'direccion' => 'Av. Corrientes 1234, CABA',
            'horario_semana' => 'Lunes a Viernes: 06:00 - 23:00',
            'horario_sabado' => 'Sábados: 08:00 - 20:00',
        ];
    }
}
