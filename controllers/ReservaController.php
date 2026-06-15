<?php

require_once __DIR__ . "/../models/ReservaModel.php";

class ReservaController
{
    private ReservaModel $reservaModel;

    public function __construct()
    {
        $this->reservaModel = new ReservaModel();
    }

    public function listar(): array
    {
        return $this->reservaModel->listarReservas();
    }

    public function obtenerPorId(int $id_reserva): ?array
    {
        return $this->reservaModel->obtenerReservaPorId($id_reserva);
    }

    public function guardar(array $datos): string
    {
        if (
            empty($datos["id_paquete"]) ||
            empty($datos["nombre_cliente"]) ||
            empty($datos["email"]) ||
            empty($datos["fecha_reserva"]) ||
            empty($datos["personas"])
        ) {
            return "Error: todos los campos obligatorios deben estar completos.";
        }

        if (!filter_var($datos["email"], FILTER_VALIDATE_EMAIL)) {
            return "Error: el correo electrónico no es válido.";
        }

        $id_paquete = (int) $datos["id_paquete"];
        $nombre_cliente = trim($datos["nombre_cliente"]);
        $email = trim($datos["email"]);
        $telefono = trim($datos["telefono"] ?? "");
        $fecha_reserva = trim($datos["fecha_reserva"]);
        $personas = (int) $datos["personas"];
        $notas = trim($datos["notas"] ?? "");

        if ($id_paquete <= 0) {
            return "Error: el paquete seleccionado no es válido.";
        }

        if ($personas <= 0) {
            return "Error: la cantidad de personas debe ser mayor que cero.";
        }

        $precio = $this->reservaModel->obtenerPrecioPaquete($id_paquete);

        if ($precio === null) {
            return "Error: el paquete seleccionado no existe.";
        }

        $total = $precio * $personas;

        try {
            $resultado = $this->reservaModel->crearReserva(
                $id_paquete,
                $nombre_cliente,
                $email,
                $telefono,
                $fecha_reserva,
                $personas,
                $total,
                $notas
            );

            return $resultado
                ? "Reserva guardada correctamente."
                : "Error: no se pudo guardar la reserva.";

        } catch (PDOException $e) {
            return "Error al guardar la reserva: " . $e->getMessage();
        }
    }

    public function actualizar(array $datos): string
    {
        if (
            empty($datos["id_reserva"]) ||
            empty($datos["id_paquete"]) ||
            empty($datos["nombre_cliente"]) ||
            empty($datos["email"]) ||
            empty($datos["fecha_reserva"]) ||
            empty($datos["personas"])
        ) {
            return "Error: todos los campos obligatorios deben estar completos.";
        }

        if (!filter_var($datos["email"], FILTER_VALIDATE_EMAIL)) {
            return "Error: el correo electrónico no es válido.";
        }

        $id_reserva = (int) $datos["id_reserva"];
        $id_paquete = (int) $datos["id_paquete"];
        $nombre_cliente = trim($datos["nombre_cliente"]);
        $email = trim($datos["email"]);
        $telefono = trim($datos["telefono"] ?? "");
        $fecha_reserva = trim($datos["fecha_reserva"]);
        $personas = (int) $datos["personas"];
        $notas = trim($datos["notas"] ?? "");

        if ($id_reserva <= 0) {
            return "Error: el ID de la reserva no es válido.";
        }

        if ($id_paquete <= 0) {
            return "Error: el paquete seleccionado no es válido.";
        }

        if ($personas <= 0) {
            return "Error: la cantidad de personas debe ser mayor que cero.";
        }

        $precio = $this->reservaModel->obtenerPrecioPaquete($id_paquete);

        if ($precio === null) {
            return "Error: el paquete seleccionado no existe.";
        }

        $total = $precio * $personas;

        try {
            $resultado = $this->reservaModel->actualizarReserva(
                $id_reserva,
                $id_paquete,
                $nombre_cliente,
                $email,
                $telefono,
                $fecha_reserva,
                $personas,
                $total,
                $notas
            );

            return $resultado
                ? "Reserva actualizada correctamente."
                : "Error: no se pudo actualizar la reserva.";

        } catch (PDOException $e) {
            return "Error al actualizar la reserva: " . $e->getMessage();
        }
    }

    public function eliminar(int $id_reserva): string
    {
        if ($id_reserva <= 0) {
            return "Error: ID de reserva inválido.";
        }

        try {
            $resultado = $this->reservaModel->eliminarReserva($id_reserva);

            return $resultado
                ? "Reserva eliminada correctamente."
                : "Error: no se pudo eliminar la reserva.";

        } catch (PDOException $e) {
            return "Error al eliminar la reserva: " . $e->getMessage();
        }
    }

    public function totalReservas(): int
    {
        return $this->reservaModel->contarReservas();
    }

    public function totalDineroReservas(): float
    {
        return $this->reservaModel->calcularTotalReservas();
    }
}