<?php
namespace App\Controllers;

use App\Models\Catalogo;
use App\Models\Clase;
use PDO;

class ClaseController extends Controller
{
    private const DIAS_SEMANA = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

    private Clase $clases;
    private Catalogo $catalogos;

    public function __construct(PDO $pdo)
    {
        $this->clases = new Clase($pdo);
        $this->catalogos = new Catalogo($pdo);
    }

    public function index(): void
    {
        $mensajes = [
            'created' => 'Clase creada correctamente.',
            'updated' => 'Clase actualizada correctamente.',
            'deleted' => 'Clase eliminada correctamente.',
            'error' => 'No se pudo completar la operación.',
        ];
        $status = isset($_GET['status']) && is_string($_GET['status']) ? $_GET['status'] : '';

        $this->vista('clases/index', [
            'base' => '../',
            'titulo_pagina' => 'Gestión de clases - Forja Gym',
            'pagina_activa' => 'panel',
            'registros' => $this->clases->todas(),
            'mensajes' => $mensajes,
            'status' => $status,
        ]);
    }

    public function crear(): void
    {
        $catalogos = $this->catalogos->todos();
        $datos = $this->datosVacios();
        $errores = [];

        if ($this->esPost()) {
            $datos = $this->datosDesdePost();
            $errores = $this->validar($datos, $catalogos);
            if (!csrf_valido()) {
                $errores['csrf'] = 'La sesión del formulario expiró.';
            }
            if (!$errores) {
                $this->clases->crear($datos);
                redirigir('index.php?status=created');
            }
        }

        $this->vista('clases/crear', [
            'base' => '../',
            'titulo_pagina' => 'Nueva clase - Forja Gym',
            'pagina_activa' => 'panel',
            'datos' => $datos,
            'errores' => $errores,
            'catalogos' => $catalogos,
            'dias' => self::DIAS_SEMANA,
        ]);
    }

    public function editar(): void
    {
        $id = filter_var($_GET['id'] ?? $_POST['id'] ?? '', FILTER_VALIDATE_INT);
        if ($id === false || $id < 1) {
            redirigir('index.php?status=error');
        }

        $clase = $this->clases->buscar($id);
        if (!$clase) {
            redirigir('index.php?status=error');
        }

        $catalogos = $this->catalogos->todos();
        $datos = [
            'nombre' => $clase['nombre'],
            'categoria_id' => (string) $clase['categoria_id'],
            'instructor_id' => (string) $clase['instructor_id'],
            'sede_id' => (string) $clase['sede_id'],
            'dia_semana' => $clase['dia_semana'],
            'hora' => substr($clase['hora'], 0, 5),
            'cupo' => (string) $clase['cupo'],
        ];
        $errores = [];

        if ($this->esPost()) {
            $datos = $this->datosDesdePost();
            $errores = $this->validar($datos, $catalogos);
            if (!csrf_valido()) {
                $errores['csrf'] = 'La sesión del formulario expiró.';
            }
            if (!$errores) {
                $this->clases->actualizar($id, $datos);
                redirigir('index.php?status=updated');
            }
        }

        $this->vista('clases/editar', [
            'base' => '../',
            'titulo_pagina' => 'Editar clase - Forja Gym',
            'pagina_activa' => 'panel',
            'id' => $id,
            'datos' => $datos,
            'errores' => $errores,
            'catalogos' => $catalogos,
            'dias' => self::DIAS_SEMANA,
        ]);
    }

    public function eliminar(): void
    {
        if (!$this->esPost() || !csrf_valido()) {
            redirigir('index.php?status=error');
        }

        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);
        if ($id === false || $id < 1) {
            redirigir('index.php?status=error');
        }

        $eliminada = $this->clases->eliminar($id);
        redirigir('index.php?status=' . ($eliminada ? 'deleted' : 'error'));
    }

    private function esPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    private function datosVacios(): array
    {
        return [
            'nombre' => '',
            'categoria_id' => '',
            'instructor_id' => '',
            'sede_id' => '',
            'dia_semana' => '',
            'hora' => '',
            'cupo' => '20',
        ];
    }

    private function datosDesdePost(): array
    {
        return [
            'nombre' => post('nombre'),
            'categoria_id' => post('categoria_id'),
            'instructor_id' => post('instructor_id'),
            'sede_id' => post('sede_id'),
            'dia_semana' => post('dia_semana'),
            'hora' => post('hora'),
            'cupo' => post('cupo'),
        ];
    }

    private function validar(array $datos, array $catalogos): array
    {
        $errores = [];
        $largo = mb_strlen($datos['nombre']);
        if ($largo < 3 || $largo > 60) {
            $errores['nombre'] = 'El nombre debe tener entre 3 y 60 caracteres.';
        }

        foreach (['categoria_id' => 'categorias', 'instructor_id' => 'instructores', 'sede_id' => 'sedes'] as $campo => $lista) {
            $ids = array_map(static fn(array $fila): string => (string) $fila['id'], $catalogos[$lista]);
            if (!in_array((string) $datos[$campo], $ids, true)) {
                $errores[$campo] = 'Seleccioná una opción válida.';
            }
        }

        if (!in_array($datos['dia_semana'], self::DIAS_SEMANA, true)) {
            $errores['dia_semana'] = 'Seleccioná un día válido.';
        }

        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $datos['hora'])) {
            $errores['hora'] = 'Ingresá una hora válida (HH:MM).';
        }

        if (filter_var($datos['cupo'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 200]]) === false) {
            $errores['cupo'] = 'El cupo debe ser un número entre 1 y 200.';
        }

        return $errores;
    }
}
