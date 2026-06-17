<?php
// Vista: listado de paquetes turísticos
// $paquetes viene del PaqueteController
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paquetes — Panamá Turismo</title>
    <link rel="stylesheet" href="assets/css/global.css">
</head>
<body>

<?php include __DIR__ . '/layouts/header.php'; ?>

<main>
    <h1 style="text-align:center; padding: 100px 0 20px;">Paquetes Turísticos en Panamá</h1>

    <div class="contenedor">
        <?php if (empty($paquetes)): ?>
            <p style="text-align:center; color:#666;">No hay paquetes disponibles.</p>
        <?php else: ?>
            <?php foreach ($paquetes as $p): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($p['imagen']) ?>"
                         alt="<?= htmlspecialchars($p['nombre']) ?>">
                    <h2><?= htmlspecialchars($p['nombre']) ?></h2>
                    <p>📍 <?= htmlspecialchars($p['provincia']) ?></p>
                    <p>💰 $<?= number_format($p['precio'], 2) ?> &nbsp;|&nbsp; 📅 <?= $p['dias'] ?> días</p>
                    <button onclick="window.location='index.php?ruta=paquetes&accion=detalle&id=<?= $p['id_paquete'] ?>'">
                        Ver Detalle
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/layouts/footer.php'; ?>

</body>
</html>