<?php
/*
 * Archivo: controllers/PaqueteController.php
 * Descripción: Controlador para gestión de paquetes turísticos.
 * Autor: Melany
 */

require_once __DIR__ . '/../models/PaqueteModel.php';

class PaqueteController {
    private $model;

    public function __construct($pdo) {
        $this->model = new PaqueteModel($pdo);
    }

    // Mostrar listado de paquetes
    public function index() {
        $paquetes = $this->model->getAll();
        require_once __DIR__ . '/../views/paquetes/index.php';
    }

    // Mostrar detalle de un paquete
    public function detalle($id) {
        $paquete = $this->model->getById($id);
        if (!$paquete) {
            header("Location: index.php?ruta=paquetes");
            exit;
        }
        require_once __DIR__ . '/../views/paquetes/detalle.php';
    }

    // Mostrar formulario de creación (admin)
    public function crear() {
        require_once __DIR__ . '/../views/paquetes/form.php';
    }

    // Procesar formulario de creación (admin)
    public function guardar() {
        $nombre      = trim($_POST['nombre'] ?? '');
        $provincia   = trim($_POST['provincia'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = floatval($_POST['precio'] ?? 0);
        $dias        = intval($_POST['dias'] ?? 0);
        $transporte  = trim($_POST['transporte'] ?? '');
        $imagen      = trim($_POST['imagen'] ?? '');

        if ($nombre && $provincia && $precio > 0 && $dias > 0) {
            $this->model->crear($nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen);
        }
        header("Location: index.php?ruta=paquetes");
        exit;
    }

    // Mostrar formulario de edición (admin)
    public function editar($id) {
        $paquete = $this->model->getById($id);
        if (!$paquete) {
            header("Location: index.php?ruta=paquetes");
            exit;
        }
        require_once __DIR__ . '/../views/paquetes/form.php';
    }

    // Procesar actualización (admin)
    public function actualizar($id) {
        $nombre      = trim($_POST['nombre'] ?? '');
        $provincia   = trim($_POST['provincia'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = floatval($_POST['precio'] ?? 0);
        $dias        = intval($_POST['dias'] ?? 0);
        $transporte  = trim($_POST['transporte'] ?? '');
        $imagen      = trim($_POST['imagen'] ?? '');

        if ($nombre && $provincia && $precio > 0 && $dias > 0) {
            $this->model->actualizar($id, $nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen);
        }
        header("Location: index.php?ruta=paquetes");
        exit;
    }

    // Eliminar paquete (admin)
    public function eliminar($id) {
        $this->model->eliminar($id);
        header("Location: index.php?ruta=paquetes");
        exit;
    }
}