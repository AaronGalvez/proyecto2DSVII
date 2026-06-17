<?php
// Vista: detalle de un paquete + modal de reserva
// $paquete viene del PaqueteController
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($paquete['nombre']) ?> — Panamá Turismo</title>
    <link rel="stylesheet" href="assets/css/global.css">
</head>
<body>

<?php include __DIR__ . '/layouts/header.php'; ?>

<main>
    <div class="container" style="margin-top: 90px;">

        <img src="<?= htmlspecialchars($paquete['imagen']) ?>"
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
            <p><strong>Días:</strong> <?= $paquete['dias'] ?> días</p>
            <p><strong>Transporte:</strong> <?= htmlspecialchars($paquete['transporte']) ?></p>
        </div>

        <button class="boton-reservar" onclick="abrirFormulario()">Reservar Ahora</button>
    </div>
</main>

<!-- MODAL RESERVA -->
<div id="modalFormulario" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarFormulario()">&times;</span>
        <h2>Formulario de Reserva</h2>

        <form class="formulario" method="POST" action="index.php?ruta=reservas&accion=guardar">
            <input type="hidden" name="id_paquete" value="<?= $paquete['id_paquete'] ?>">

            <label>Nombre Completo:</label>
            <input type="text" name="nombre_cliente" required>

            <label>Correo Electrónico:</label>
            <input type="email" name="email" required>

            <label>Teléfono:</label>
            <input type="tel" name="telefono">

            <label>Fecha de Viaje:</label>
            <input type="date" name="fecha_reserva" required>

            <label>Número de Personas:</label>
            <input type="number" name="personas" min="1" required>

            <label>Notas Adicionales:</label>
            <textarea name="notas" rows="4"
                      placeholder="Cuéntanos si tienes alguna solicitud especial..."></textarea>

            <div class="botones-form">
                <button type="submit" class="btn-enviar">Enviar Reserva</button>
                <button type="button" class="btn-cancelar" onclick="cerrarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>

<script>
    function abrirFormulario() {
        document.getElementById("modalFormulario").style.display = "flex";
    }
    function cerrarFormulario() {
        document.getElementById("modalFormulario").style.display = "none";
    }
    window.onclick = function(e) {
        if (e.target === document.getElementById("modalFormulario"))
            document.getElementById("modalFormulario").style.display = "none";
    }
</script>
</body>
</html>