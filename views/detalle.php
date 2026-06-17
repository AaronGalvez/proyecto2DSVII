<?php
/*
 * Archivo: views/paquetes/detalle.php
 * Descripción: Vista detalle de un paquete turístico.
 * Autor: Melany
 */
$tituloPagina = htmlspecialchars($paquete['nombre']) . ' — Panamá Turismo';
require_once __DIR__ . '/../layouts/header.php';
?>

<link rel="stylesheet" href="assets/css/styles.css">

<div class="container" style="margin-top: 90px;">

    <img src="<?= htmlspecialchars($paquete['imagen']) ?>"
         alt="<?= htmlspecialchars($paquete['nombre']) ?>"
         class="imagen-destino">

    <h1><?= htmlspecialchars($paquete['nombre']) ?></h1>
    <p class="descripcion">
        Descubre <?= htmlspecialchars($paquete['nombre']) ?>, ubicado en <?= htmlspecialchars($paquete['provincia']) ?>.
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

<!-- MODAL DE RESERVA -->
<div id="modalFormulario" class="modal">
    <div class="modal-content">
        <span class="cerrar" onclick="cerrarFormulario()">&times;</span>
        <h2>Formulario de Reserva</h2>

        <form class="formulario" method="POST" action="index.php?ruta=reservas&accion=guardar">
            <input type="hidden" name="id_paquete" value="<?= $paquete['id_paquete'] ?>">

            <label for="nombre_cliente">Nombre Completo:</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono">

            <label for="fecha_reserva">Fecha de Viaje:</label>
            <input type="date" id="fecha_reserva" name="fecha_reserva" required>

            <label for="personas">Número de Personas:</label>
            <input type="number" id="personas" name="personas" min="1" required>

            <label for="notas">Notas Adicionales:</label>
            <textarea id="notas" name="notas" rows="4"
                      placeholder="Cuéntanos si tienes alguna solicitud especial..."></textarea>

            <div class="botones-form">
                <button type="submit" class="btn-enviar">Enviar Reserva</button>
                <button type="button" class="btn-cancelar" onclick="cerrarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirFormulario() {
        document.getElementById("modalFormulario").style.display = "flex";
    }
    function cerrarFormulario() {
        document.getElementById("modalFormulario").style.display = "none";
    }
    window.onclick = function(e) {
        let modal = document.getElementById("modalFormulario");
        if (e.target === modal) modal.style.display = "none";
    }
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>