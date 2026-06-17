<?php
/*
 * Archivo: models/PaqueteModel.php
 * Descripción: Modelo para operaciones CRUD de paquetes turísticos.
 * Autor: Melany
 */

class PaqueteModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los paquetes
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM paquetes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un paquete por ID
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM paquetes WHERE id_paquete = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar nuevo paquete
    public function crear($nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO paquetes (nombre, provincia, descripcion, precio, dias, transporte, imagen)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen]);
    }

    // Actualizar paquete existente
    public function actualizar($id, $nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen) {
        $stmt = $this->pdo->prepare(
            "UPDATE paquetes SET nombre=?, provincia=?, descripcion=?, precio=?, dias=?, transporte=?, imagen=?
             WHERE id_paquete=?"
        );
        return $stmt->execute([$nombre, $provincia, $descripcion, $precio, $dias, $transporte, $imagen, $id]);
    }

    // Eliminar paquete
    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM paquetes WHERE id_paquete = ?");
        return $stmt->execute([$id]);
    }
}