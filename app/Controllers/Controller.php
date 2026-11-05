<?php
namespace App\Controllers;

abstract class Controller
{
    protected function vista(string $ruta, array $parametros = []): void
    {
        extract($parametros, EXTR_SKIP);
        require __DIR__ . '/../Views/' . $ruta . '.php';
    }
}
