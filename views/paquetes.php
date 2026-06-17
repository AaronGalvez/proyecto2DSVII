<?php
/*
 * Archivo: views/paquetes/index.php
 * Descripción: Vista listado de paquetes turísticos.
 * Autor: Melany
 */
$tituloPagina = 'Paquetes de Viaje';
$cssExtra = 'paquetesE.css';
require_once __DIR__ . '/../layouts/header.php';
?>

<h1 style="text-align:center; padding: 90px 0 20px;">Paquetes Turísticos en Panamá</h1>

<div class="contenedor">
    <?php if (empty($paquetes)): ?>
        <p style="text-align:center; color:#666;">No hay paquetes disponibles por el momento.</p>
    <?php else: ?>
        <?php foreach ($paquetes as $p): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
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

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>