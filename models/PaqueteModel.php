<?php

require_once __DIR__ . '/../config/database.php';

class PaqueteModel
{
    private PDO $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->conectar();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM paquetes ORDER BY id_paquete DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM paquetes WHERE id_paquete = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    public function crear(
        string $nombre,
        string $provincia,
        string $descripcion,
        float  $precio,
        int    $dias,
        string $transporte,
        string $imagen
    ): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO paquetes (nombre, provincia, descripcion, precio, dias, transporte, imagen)
             VALUES (:nombre, :provincia, :descripcion, :precio, :dias, :transporte, :imagen)"
        );
        $stmt->bindParam(':nombre',      $nombre);
        $stmt->bindParam(':provincia',   $provincia);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio',      $precio);
        $stmt->bindParam(':dias',        $dias,      PDO::PARAM_INT);
        $stmt->bindParam(':transporte',  $transporte);
        $stmt->bindParam(':imagen',      $imagen);
        return $stmt->execute();
    }

    public function actualizar(
        int    $id,
        string $nombre,
        string $provincia,
        string $descripcion,
        float  $precio,
        int    $dias,
        string $transporte,
        string $imagen
    ): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE paquetes
             SET nombre = :nombre,
                 provincia = :provincia,
                 descripcion = :descripcion,
                 precio = :precio,
                 dias = :dias,
                 transporte = :transporte,
                 imagen = :imagen
             WHERE id_paquete = :id"
        );
        $stmt->bindParam(':id',          $id,        PDO::PARAM_INT);
        $stmt->bindParam(':nombre',      $nombre);
        $stmt->bindParam(':provincia',   $provincia);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio',      $precio);
        $stmt->bindParam(':dias',        $dias,      PDO::PARAM_INT);
        $stmt->bindParam(':transporte',  $transporte);
        $stmt->bindParam(':imagen',      $imagen);
        return $stmt->execute();
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM paquetes WHERE id_paquete = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /** Cuenta el total de paquetes (útil para el dashboard) */
    public function contarPaquetes(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM paquetes");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $resultado['total'];
    }
}
