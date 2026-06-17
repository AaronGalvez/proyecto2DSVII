<?php

require_once __DIR__ . '/../models/PaqueteModel.php';

class PaqueteController {

    private $model;

    public function __construct() {
        $this->model = new PaqueteModel();
    }

    public function index() {
        $paquetes = $this->model->getAll();
        require_once __DIR__ . '/../views/paquetes.php';
    }

    public function detalle($id) {
        $paquete = $this->model->getById($id);
        if (!$paquete) {
            header("Location: index.php?ruta=paquetes");
            exit;
        }
        require_once __DIR__ . '/../views/detalle.php';
    }

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

    public function eliminar($id) {
        $this->model->eliminar($id);
        header("Location: index.php?ruta=paquetes");
        exit;
    }
}