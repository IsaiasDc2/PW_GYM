<?php

function limpiar_texto(?string $valor): string
{
    return trim($valor ?? '');
}

function e(?string $valor): string
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

function post(string $clave): string
{
    $valor = filter_input(INPUT_POST, $clave, FILTER_UNSAFE_RAW);
    if ($valor === null || $valor === false) {
        $valor = $_POST[$clave] ?? '';
    }
    return limpiar_texto(is_string($valor) ? $valor : '');
}

function get_param(string $clave): string
{
    $valor = filter_input(INPUT_GET, $clave, FILTER_UNSAFE_RAW);
    if ($valor === null || $valor === false) {
        $valor = $_GET[$clave] ?? '';
    }
    return limpiar_texto(is_string($valor) ? $valor : '');
}

function sedes_validas(): array
{
    return ['Centro', 'Norte', 'Sur'];
}

function categorias_validas(): array
{
    return ['Funcional', 'Spinning', 'CrossFit', 'Yoga', 'Boxing', 'Pilates'];
}

function validar_contacto(array $entrada): array
{
    $datos = [
        'nombre'   => limpiar_texto($entrada['nombre'] ?? ''),
        'apellido' => limpiar_texto($entrada['apellido'] ?? ''),
        'email'    => limpiar_texto($entrada['email'] ?? ''),
        'telefono' => limpiar_texto($entrada['telefono'] ?? ''),
        'sede'     => limpiar_texto($entrada['sede'] ?? ''),
        'mensaje'  => limpiar_texto($entrada['mensaje'] ?? ''),
    ];
    $errores = [];

    if ($datos['nombre'] === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (mb_strlen($datos['nombre']) < 2) {
        $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
    } elseif (mb_strlen($datos['nombre']) > 50) {
        $errores['nombre'] = 'El nombre no puede superar 50 caracteres.';
    } elseif (!preg_match('/^[\p{L} \'-]+$/u', $datos['nombre'])) {
        $errores['nombre'] = 'El nombre solo puede contener letras, espacios, apóstrofes y guiones.';
    }

    if ($datos['apellido'] === '') {
        $errores['apellido'] = 'El apellido es obligatorio.';
    } elseif (mb_strlen($datos['apellido']) < 2) {
        $errores['apellido'] = 'El apellido debe tener al menos 2 caracteres.';
    } elseif (mb_strlen($datos['apellido']) > 50) {
        $errores['apellido'] = 'El apellido no puede superar 50 caracteres.';
    } elseif (!preg_match('/^[\p{L} \'-]+$/u', $datos['apellido'])) {
        $errores['apellido'] = 'El apellido solo puede contener letras, espacios, apóstrofes y guiones.';
    }

    if ($datos['email'] === '') {
        $errores['email'] = 'El email es obligatorio.';
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'El formato del email no es válido.';
    } elseif (mb_strlen($datos['email']) > 120) {
        $errores['email'] = 'El email no puede superar 120 caracteres.';
    }

    if ($datos['telefono'] !== '' && !preg_match('/^[0-9+\-() ]{7,20}$/', $datos['telefono'])) {
        $errores['telefono'] = 'El teléfono solo admite números, espacios y + - ( ) (7 a 20 caracteres).';
    }

    if ($datos['sede'] === '') {
        $errores['sede'] = 'Elegí una sede de interés.';
    } elseif (!in_array($datos['sede'], sedes_validas(), true)) {
        $errores['sede'] = 'La sede seleccionada no es válida.';
    }

    if ($datos['mensaje'] === '') {
        $errores['mensaje'] = 'El mensaje es obligatorio.';
    } elseif (mb_strlen($datos['mensaje']) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    } elseif (mb_strlen($datos['mensaje']) > 1000) {
        $errores['mensaje'] = 'El mensaje no puede superar 1000 caracteres.';
    }

    return ['errores' => $errores, 'datos' => $datos];
}

function filtrar_clases(array $clases, string $q, string $cat): array
{
    $q = mb_strtolower($q);
    return array_values(array_filter($clases, function ($c) use ($q, $cat) {
        if ($cat !== '' && $c['categoria'] !== $cat) {
            return false;
        }
        if ($q === '') {
            return true;
        }
        $texto = mb_strtolower($c['nombre'] . ' ' . $c['categoria'] . ' ' . $c['instructor'] . ' ' . $c['horario']);
        return mb_strpos($texto, $q) !== false;
    }));
}
