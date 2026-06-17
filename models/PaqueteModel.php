<?php

require_once __DIR__ . '/../config/database.php';

class PaqueteModel {

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->conectar();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM paquetes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM paquetes WHERE id_paquete = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO paquetes (nombre, provincia, descripcion, precio, dias, transporte, imagen)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen]);
    }

    public function actualizar($id, $nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen) {
        $stmt = $this->pdo->prepare(
            "UPDATE paquetes SET nombre=?, provincia=?, descripcion=?, precio=?, dias=?, transporte=?, imagen=?
             WHERE id_paquete=?"
        );
        return $stmt->execute([$nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM paquetes WHERE id_paquete = ?");
        return $stmt->execute([$id]);
    }
}