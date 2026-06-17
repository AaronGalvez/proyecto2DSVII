<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Panamá Turismo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 text-center mb-4">Panel Administrativo</h1>

                        <?php if ($flash): ?>
                            <div class="alert alert-<?= htmlspecialchars($flash['tipo'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($flash['mensaje'], ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?controller=admin&action=autenticar" method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" name="usuario" id="usuario" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                        </form>

                        <p class="text-muted small mt-3 mb-0">
                            Usuarios iniciales: Kevin22, Amy33 o Aaron44. Contraseña: 1GS134.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
