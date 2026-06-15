<?php

require_once __DIR__ . "/../config/database.php";

class ReservaModel
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listarReservas(): array
    {
        $sql = "SELECT 
                    r.id_reserva,
                    r.id_paquete,
                    p.nombre,
                    p.provincia,
                    p.precio,
                    r.nombre_cliente,
                    r.email,
                    r.telefono,
                    r.fecha_reserva,
                    r.personas,
                    r.total,
                    r.notas,
                    r.fecha_creacion
                FROM reservas r
                INNER JOIN paquetes p ON r.id_paquete = p.id_paquete
                ORDER BY r.id_reserva DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerReservaPorId(int $id_reserva): ?array
    {
        $sql = "SELECT 
                    r.id_reserva,
                    r.id_paquete,
                    p.nombre,
                    p.provincia,
                    p.precio,
                    r.nombre_cliente,
                    r.email,
                    r.telefono,
                    r.fecha_reserva,
                    r.personas,
                    r.total,
                    r.notas,
                    r.fecha_creacion
                FROM reservas r
                INNER JOIN paquetes p ON r.id_paquete = p.id_paquete
                WHERE r.id_reserva = :id_reserva";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);
        $stmt->execute();

        $reserva = $stmt->fetch();

        return $reserva ?: null;
    }

    public function obtenerPrecioPaquete(int $id_paquete): ?float
    {
        $sql = "SELECT precio 
                FROM paquetes 
                WHERE id_paquete = :id_paquete";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_paquete", $id_paquete, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch();

        if (!$resultado) {
            return null;
        }

        return (float) $resultado["precio"];
    }

    public function crearReserva(
        int $id_paquete,
        string $nombre_cliente,
        string $email,
        string $telefono,
        string $fecha_reserva,
        int $personas,
        float $total,
        string $notas
    ): bool {
        $sql = "INSERT INTO reservas
                (
                    id_paquete,
                    nombre_cliente,
                    email,
                    telefono,
                    fecha_reserva,
                    personas,
                    total,
                    notas
                )
                VALUES
                (
                    :id_paquete,
                    :nombre_cliente,
                    :email,
                    :telefono,
                    :fecha_reserva,
                    :personas,
                    :total,
                    :notas
                )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id_paquete", $id_paquete, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_cliente", $nombre_cliente);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":fecha_reserva", $fecha_reserva);
        $stmt->bindParam(":personas", $personas, PDO::PARAM_INT);
        $stmt->bindParam(":total", $total);
        $stmt->bindParam(":notas", $notas);

        return $stmt->execute();
    }

    public function actualizarReserva(
        int $id_reserva,
        int $id_paquete,
        string $nombre_cliente,
        string $email,
        string $telefono,
        string $fecha_reserva,
        int $personas,
        float $total,
        string $notas
    ): bool {
        $sql = "UPDATE reservas
                SET
                    id_paquete = :id_paquete,
                    nombre_cliente = :nombre_cliente,
                    email = :email,
                    telefono = :telefono,
                    fecha_reserva = :fecha_reserva,
                    personas = :personas,
                    total = :total,
                    notas = :notas
                WHERE id_reserva = :id_reserva";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);
        $stmt->bindParam(":id_paquete", $id_paquete, PDO::PARAM_INT);
        $stmt->bindParam(":nombre_cliente", $nombre_cliente);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":fecha_reserva", $fecha_reserva);
        $stmt->bindParam(":personas", $personas, PDO::PARAM_INT);
        $stmt->bindParam(":total", $total);
        $stmt->bindParam(":notas", $notas);

        return $stmt->execute();
    }

    public function eliminarReserva(int $id_reserva): bool
    {
        $sql = "DELETE FROM reservas 
                WHERE id_reserva = :id_reserva";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_reserva", $id_reserva, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function contarReservas(): int
    {
        $sql = "SELECT COUNT(*) AS total_reservas 
                FROM reservas";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetch();

        return (int) $resultado["total_reservas"];
    }

    public function calcularTotalReservas(): float
    {
        $sql = "SELECT COALESCE(SUM(total), 0) AS total_reservas
                FROM reservas";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $resultado = $stmt->fetch();

        return (float) $resultado["total_reservas"];
    }
}