<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Administradores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php?controller=admin&action=usuarios">Panamá Turismo Admin</a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white small">
                    <?= e($_SESSION['admin_usuario'] ?? 'Admin') ?>
                </span>
                <a class="btn btn-outline-light btn-sm" href="index.php?controller=admin&action=logout">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-0">Gestión de Administradores</h1>
                <p class="text-muted mb-0">Crear, editar y eliminar usuarios administradores.</p>
            </div>
        </div>

        <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['tipo']) ?>">
                <?= e($flash['mensaje']) ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <strong>Administradores registrados</strong>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($usuarios)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">No hay administradores registrados.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($usuarios as $admin): ?>
                                            <tr>
                                                <td><?= (int) $admin['id_admin'] ?></td>
                                                <td><?= e($admin['usuario']) ?></td>
                                                <td class="text-end">
                                                    <a class="btn btn-warning btn-sm" href="index.php?controller=admin&action=editarUsuario&id=<?= (int) $admin['id_admin'] ?>">
                                                        Editar
                                                    </a>
                                                    <a class="btn btn-danger btn-sm"
                                                       href="index.php?controller=admin&action=eliminarUsuario&id=<?= (int) $admin['id_admin'] ?>"
                                                       onclick="return confirm('¿Seguro que deseas eliminar este administrador?');">
                                                        Eliminar
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <?php if ($usuarioEditar): ?>
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-warning">
                            <strong>Editar administrador</strong>
                        </div>
                        <div class="card-body">
                            <form action="index.php?controller=admin&action=actualizarUsuario" method="POST">
                                <input type="hidden" name="id_admin" value="<?= (int) $usuarioEditar['id_admin'] ?>">

                                <div class="mb-3">
                                    <label for="usuario_editar" class="form-label">Usuario</label>
                                    <input type="text" name="usuario" id="usuario_editar" class="form-control" required minlength="3" value="<?= e($usuarioEditar['usuario']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="password_editar" class="form-label">Nueva contraseña</label>
                                    <input type="password" name="password" id="password_editar" class="form-control" minlength="6">
                                    <div class="form-text">Déjala vacía para conservar la contraseña actual.</div>
                                </div>

                                <button type="submit" class="btn btn-warning">Actualizar</button>
                                <a href="index.php?controller=admin&action=usuarios" class="btn btn-secondary">Cancelar</a>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <strong>Crear administrador</strong>
                    </div>
                    <div class="card-body">
                        <form action="index.php?controller=admin&action=guardarUsuario" method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" name="usuario" id="usuario" class="form-control" required minlength="3">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" required minlength="6">
                            </div>

                            <button type="submit" class="btn btn-primary">Crear administrador</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
