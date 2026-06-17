<?php
// views/paquetes.php — Vista listado de paquetes
// $paquetes viene del PaqueteController
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paquetes — Panamá Turismo</title>
    <!-- CSS global: navbar, footer, variables -->
    <link rel="stylesheet" href="assets/css/global.css">
    <!-- CSS propio de esta sección -->
    <link rel="stylesheet" href="assets/css/paquetes.css">
    <!-- Iconos Tabler -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body>

<?php include __DIR__ . '/layouts/header.php'; ?>

<h1 class="paquetes-titulo">Paquetes Turísticos en Panamá</h1>

<div class="contenedor">
    <?php if (empty($paquetes)): ?>
        <p style="text-align:center; color:var(--gris); padding: 40px 0;">
            No hay paquetes disponibles en este momento.
        </p>
    <?php else: ?>
        <?php foreach ($paquetes as $p): ?>
            <div class="card">
                <img
                    src="<?= htmlspecialchars($p['imagen']) ?>"
                    alt="<?= htmlspecialchars($p['nombre']) ?>"
                    loading="lazy">
                <h2><?= htmlspecialchars($p['nombre']) ?></h2>
                <p><?= htmlspecialchars($p['descripcion']) ?></p>
                <p class="card-precio">
                    $<?= number_format($p['precio'], 2) ?> &nbsp;·&nbsp; <?= (int)$p['dias'] ?> días
                </p>
                <button onclick="window.location='index.php?ruta=paquetes&accion=detalle&id=<?= (int)$p['id_paquete'] ?>'">
                    <i class="ti ti-eye"></i> Ver Detalle
                </button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>

<script src="assets/js/animacion.js" defer></script>

</body>
</html>
