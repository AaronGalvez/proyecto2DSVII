<?php
// views/detalle.php — Vista detalle de un paquete
// $paquete viene del PaqueteController
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($paquete['nombre']) ?> — Panamá Turismo</title>
    <!-- CSS global: navbar, footer, variables -->
    <link rel="stylesheet" href="assets/css/global.css">
    <!-- CSS propio de esta sección -->
    <link rel="stylesheet" href="assets/css/paquetes.css">
    <!-- Iconos Tabler -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
</head>
<body>

<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="detalle-wrapper">

    <img
        src="<?= htmlspecialchars($paquete['imagen']) ?>"
        alt="<?= htmlspecialchars($paquete['nombre']) ?>"
        class="imagen-destino">

    <h1><?= htmlspecialchars($paquete['nombre']) ?></h1>

    <p class="descripcion">
        Descubre <?= htmlspecialchars($paquete['nombre']) ?>,
        ubicado en <?= htmlspecialchars($paquete['provincia']) ?>.
        <?= htmlspecialchars($paquete['descripcion']) ?>
    </p>

    <div class="info-viaje">
        <p><strong>Destino:</strong> <?= htmlspecialchars($paquete['nombre']) ?></p>
        <p><strong>Provincia:</strong> <?= htmlspecialchars($paquete['provincia']) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($paquete['precio'], 2) ?></p>
        <p><strong>Días:</strong> <?= (int)$paquete['dias'] ?> días</p>
        <p><strong>Transporte:</strong> <?= htmlspecialchars($paquete['transporte']) ?></p>
    </div>

    <button class="boton-reservar" onclick="abrirFormulario()">
        <i class="ti ti-calendar-plus"></i> Reservar Ahora
    </button>

</div>

<!-- MODAL RESERVA -->
<div id="modalFormulario" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarFormulario()">&times;</span>
        <h2> Formulario de Reserva</h2>

        <form class="formulario" method="POST" action="index.php?ruta=reservas&accion=guardar">
            <input type="hidden" name="id_paquete" value="<?= (int)$paquete['id_paquete'] ?>">

            <label for="nombre_cliente">Nombre Completo:</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" required placeholder="Tu nombre completo">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="correo@ejemplo.com">

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" placeholder="+507 6000-0000">

            <label for="fecha_reserva">Fecha de Viaje:</label>
            <input type="date" id="fecha_reserva" name="fecha_reserva" required
                   min="<?= date('Y-m-d') ?>">

            <label for="personas">Número de Personas:</label>
            <input type="number" id="personas" name="personas" min="1" required placeholder="1">

            <label for="notas">Notas Adicionales:</label>
            <textarea id="notas" name="notas" rows="3"
                      placeholder="Cuéntanos si tienes alguna solicitud especial..."></textarea>

            <div class="botones-form">
                <button type="submit" class="btn-enviar">
                    <i class="ti ti-send"></i> Enviar Reserva
                </button>
                <button type="button" class="btn-cancelar" onclick="cerrarFormulario()">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>

<script>
    function abrirFormulario() {
        document.getElementById("modalFormulario").style.display = "flex";
        document.body.style.overflow = "hidden";
    }
    function cerrarFormulario() {
        document.getElementById("modalFormulario").style.display = "none";
        document.body.style.overflow = "";
    }
    window.addEventListener("click", function (e) {
        const modal = document.getElementById("modalFormulario");
        if (e.target === modal) cerrarFormulario();
    });
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") cerrarFormulario();
    });
</script>

<script src="assets/js/animacion.js" defer></script>

</body>
</html>
