<?php

require_once __DIR__ . '/../models/PaqueteModel.php';

class PaqueteController
{
    private PaqueteModel $model;

    public function __construct()
    {
        $this->model = new PaqueteModel();
    }

    /** Lista todos los paquetes → views/paquetes.php */
    public function index(): void
    {
        $paquetes = $this->model->getAll();
        require_once __DIR__ . '/../views/paquetes.php';
    }

    /** Muestra el detalle de un paquete → views/detalle.php */
    public function detalle(int $id): void
    {
        if ($id <= 0) {
            header("Location: index.php?ruta=paquetes");
            exit;
        }

        $paquete = $this->model->getById($id);

        if (!$paquete) {
            header("Location: index.php?ruta=paquetes");
            exit;
        }

        require_once __DIR__ . '/../views/detalle.php';
    }

    /** Crea un nuevo paquete (recibe POST) */
    public function guardar(): void
    {
        $nombre      = trim($_POST['nombre']      ?? '');
        $provincia   = trim($_POST['provincia']   ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = floatval($_POST['precio']  ?? 0);
        $dias        = intval($_POST['dias']       ?? 0);
        $transporte  = trim($_POST['transporte']  ?? '');
        $imagen      = trim($_POST['imagen']      ?? '');

        if ($nombre && $provincia && $precio > 0 && $dias > 0) {
            $this->model->crear($nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen);
        }

        header("Location: index.php?ruta=paquetes");
        exit;
    }

    /** Actualiza un paquete existente (recibe POST) */
    public function actualizar(int $id): void
    {
        if ($id <= 0) {
            header("Location: index.php?ruta=paquetes");
            exit;
        }

        $nombre      = trim($_POST['nombre']      ?? '');
        $provincia   = trim($_POST['provincia']   ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = floatval($_POST['precio']  ?? 0);
        $dias        = intval($_POST['dias']       ?? 0);
        $transporte  = trim($_POST['transporte']  ?? '');
        $imagen      = trim($_POST['imagen']      ?? '');

        if ($nombre && $provincia && $precio > 0 && $dias > 0) {
            $this->model->actualizar($id, $nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen);
        }

        header("Location: index.php?ruta=paquetes");
        exit;
    }

    /** Elimina un paquete */
    public function eliminar(int $id): void
    {
        if ($id > 0) {
            $this->model->eliminar($id);
        }
        header("Location: index.php?ruta=paquetes");
        exit;
    }

    /** Total de paquetes (para el dashboard de Aaron/Kevin) */
    public function totalPaquetes(): int
    {
        return $this->model->contarPaquetes();
    }
}
