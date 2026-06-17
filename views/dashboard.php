<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Panamá Turismo Admin</span>
            <a class="btn btn-outline-light btn-sm" href="index.php?controller=admin&action=logout">Cerrar sesión</a>
        </div>
    </nav>

    <main class="container py-4">
        <h1 class="h3">Panel Administrativo</h1>
        <p class="text-muted">Accesos rápidos del sistema.</p>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5">Usuarios Admin</h2>
                        <p class="text-muted">Gestionar administradores del sistema.</p>
                        <a href="index.php?controller=admin&action=usuarios" class="btn btn-primary">Administradores</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
