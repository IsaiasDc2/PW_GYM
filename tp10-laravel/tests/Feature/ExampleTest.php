<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_la_raiz_redirige_al_modulo_de_sedes(): void
    {
        $this->get('/')->assertRedirect('/sedes');
    }
}
