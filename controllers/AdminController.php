<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class AdminController
{
    private UsuarioModel $usuarioModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->usuarioModel = new UsuarioModel();
    }

    private function redirigir(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    private function flash(string $tipo, string $mensaje): void
    {
        $_SESSION['flash'] = [
            'tipo' => $tipo,
            'mensaje' => $mensaje,
        ];
    }

    // Bloquea pantallas administrativas si no hay sesión activa.
    private function proteger(): void
    {
        if (empty($_SESSION['admin_id'])) {
            $this->flash('danger', 'Debes iniciar sesión para acceder al panel administrativo.');
            $this->redirigir('index.php?controller=admin&action=login');
        }
    }

    public function login(): void
    {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        require __DIR__ . '/../views/login.php';
    }

    public function autenticar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('index.php?controller=admin&action=login');
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($usuario === '' || $password === '') {
            $this->flash('danger', 'Usuario y contraseña son obligatorios.');
            $this->redirigir('index.php?controller=admin&action=login');
        }

        $admin = $this->usuarioModel->autenticar($usuario, $password);

        if (!$admin) {
            $this->flash('danger', 'Credenciales incorrectas.');
            $this->redirigir('index.php?controller=admin&action=login');
        }

        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_usuario'] = $admin['usuario'];

        $this->flash('success', 'Sesión iniciada correctamente.');
        $this->redirigir('index.php?controller=admin&action=usuarios');
    }

    public function logout(): void
    {
        session_destroy();
        session_start();
        $this->flash('success', 'Sesión cerrada correctamente.');
        $this->redirigir('index.php?controller=admin&action=login');
    }

    public function dashboard(): void
    {
        $this->proteger();
        require __DIR__ . '/../views/dashboard.php';
    }

    public function usuarios(): void
    {
        $this->proteger();

        $usuarios = $this->usuarioModel->obtenerTodos();
        $usuarioEditar = null;

        require __DIR__ . '/../views/usuarios.php';
    }

    public function editarUsuario(): void
    {
        $this->proteger();

        $id = (int) ($_GET['id'] ?? 0);
        $usuarioEditar = $this->usuarioModel->obtenerPorId($id);

        if (!$usuarioEditar) {
            $this->flash('danger', 'El administrador seleccionado no existe.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        $usuarios = $this->usuarioModel->obtenerTodos();
        require __DIR__ . '/../views/usuarios.php';
    }

    public function guardarUsuario(): void
    {
        $this->proteger();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($usuario === '' || strlen($usuario) < 3) {
            $this->flash('danger', 'El usuario es obligatorio y debe tener mínimo 3 caracteres.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        if ($password === '' || strlen($password) < 6) {
            $this->flash('danger', 'La contraseña es obligatoria y debe tener mínimo 6 caracteres.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        if ($this->usuarioModel->existeUsuario($usuario)) {
            $this->flash('danger', 'Ya existe un administrador con ese usuario.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        $this->usuarioModel->crear($usuario, $password);
        $this->flash('success', 'Administrador creado correctamente.');
        $this->redirigir('index.php?controller=admin&action=usuarios');
    }

    public function actualizarUsuario(): void
    {
        $this->proteger();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        $id = (int) ($_POST['id_admin'] ?? 0);
        $usuario = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($id <= 0 || !$this->usuarioModel->obtenerPorId($id)) {
            $this->flash('danger', 'Administrador inválido.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        if ($usuario === '' || strlen($usuario) < 3) {
            $this->flash('danger', 'El usuario es obligatorio y debe tener mínimo 3 caracteres.');
            $this->redirigir('index.php?controller=admin&action=editarUsuario&id=' . $id);
        }

        if ($password !== '' && strlen($password) < 6) {
            $this->flash('danger', 'La nueva contraseña debe tener mínimo 6 caracteres.');
            $this->redirigir('index.php?controller=admin&action=editarUsuario&id=' . $id);
        }

        if ($this->usuarioModel->existeUsuario($usuario, $id)) {
            $this->flash('danger', 'Ya existe otro administrador con ese usuario.');
            $this->redirigir('index.php?controller=admin&action=editarUsuario&id=' . $id);
        }

        $passwordParaGuardar = $password === '' ? null : $password;
        $this->usuarioModel->actualizar($id, $usuario, $passwordParaGuardar);

        $this->flash('success', 'Administrador actualizado correctamente.');
        $this->redirigir('index.php?controller=admin&action=usuarios');
    }

    public function eliminarUsuario(): void
    {
        $this->proteger();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0 || !$this->usuarioModel->obtenerPorId($id)) {
            $this->flash('danger', 'Administrador inválido.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        if ($this->usuarioModel->contarAdministradores() <= 1) {
            $this->flash('danger', 'No se puede eliminar el último administrador del sistema.');
            $this->redirigir('index.php?controller=admin&action=usuarios');
        }

        $this->usuarioModel->eliminar($id);
        $this->flash('success', 'Administrador eliminado correctamente.');
        $this->redirigir('index.php?controller=admin&action=usuarios');
    }
}
