<?php

require_once __DIR__ . '/../config/database.php';

class UsuarioModel
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Lista todos los administradores registrados.
    public function obtenerTodos(): array
    {
        $sql = 'SELECT id_admin, usuario FROM administradores ORDER BY id_admin DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Busca un administrador por su ID.
    public function obtenerPorId(int $id): ?array
    {
        $sql = 'SELECT id_admin, usuario, password FROM administradores WHERE id_admin = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    // Busca un administrador por nombre de usuario.
    public function obtenerPorUsuario(string $usuario): ?array
    {
        $sql = 'SELECT id_admin, usuario, password FROM administradores WHERE usuario = :usuario LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $admin = $stmt->fetch();

        return $admin ?: null;
    }

    // Verifica si un usuario ya existe. En edición puede excluir el ID actual.
    public function existeUsuario(string $usuario, ?int $idExcluir = null): bool
    {
        if ($idExcluir !== null) {
            $sql = 'SELECT COUNT(*) FROM administradores WHERE usuario = :usuario AND id_admin != :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':usuario' => $usuario,
                ':id' => $idExcluir,
            ]);
        } else {
            $sql = 'SELECT COUNT(*) FROM administradores WHERE usuario = :usuario';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);
        }

        return (int) $stmt->fetchColumn() > 0;
    }

    // Crea un nuevo administrador.
    // Se mantiene password en texto plano por compatibilidad con el SQL actual del equipo.
    public function crear(string $usuario, string $password): bool
    {
        $sql = 'INSERT INTO administradores (usuario, password) VALUES (:usuario, :password)';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':usuario' => $usuario,
            ':password' => $password,
        ]);
    }

    // Actualiza usuario y, opcionalmente, contraseña.
    // Si password viene vacío, conserva la contraseña anterior.
    public function actualizar(int $id, string $usuario, ?string $password = null): bool
    {
        if ($password === null || trim($password) === '') {
            $sql = 'UPDATE administradores SET usuario = :usuario WHERE id_admin = :id';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':usuario' => $usuario,
                ':id' => $id,
            ]);
        }

        $sql = 'UPDATE administradores SET usuario = :usuario, password = :password WHERE id_admin = :id';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':usuario' => $usuario,
            ':password' => $password,
            ':id' => $id,
        ]);
    }

    // Elimina un administrador por ID.
    public function eliminar(int $id): bool
    {
        $sql = 'DELETE FROM administradores WHERE id_admin = :id';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Cuenta cuántos administradores existen.
    public function contarAdministradores(): int
    {
        $sql = 'SELECT COUNT(*) FROM administradores';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    // Valida login usando usuario y password en texto plano.
    public function autenticar(string $usuario, string $password): ?array
    {
        $admin = $this->obtenerPorUsuario($usuario);

        if ($admin && $admin['password'] === $password) {
            return $admin;
        }

        return null;
    }
}
