<?php

class Database {

    private $host = "localhost";
    private $dbname = "panama_turismo";
    private $username = "root";
    private $password = "";

    public function conectar() {

        try {

            $conexion = new PDO(
                "mysql:host={$this->host};port=3307;dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $conexion;

        } catch(PDOException $e) {

            die("Error de conexión: " . $e->getMessage());

        }
    }
}