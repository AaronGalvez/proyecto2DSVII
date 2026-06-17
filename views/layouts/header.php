<!-- views/layouts/header.php — Autor: Melany -->
<nav class="pt-nav" id="ptNav">
    <div class="pt-nav-inner">

        <a href="index.php" class="pt-logo">
            <span class="pt-logo-icon">icono</span>
            <span class="pt-logo-text-wrap">
                <span class="pt-logo-text">Panamá Turismo</span>
            </span>
        </a>

        <ul class="pt-links" id="ptLinks">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php?ruta=paquetes">Paquetes</a></li>
            <li><a href="index.php?ruta=contacto">Contacto</a></li>
            <li><a href="index.php?ruta=faq">FAQ</a></li>

            <li class="pt-links-mobile-extra">
                <a href="index.php?ruta=admin"><i class="ti ti-lock"></i> Acceso administrador</a>
            </li>
            <li class="pt-links-mobile-extra">
                <a href="index.php?ruta=paquetes" class="pt-btn">Reservar ahora</a>
            </li>
        </ul>

        <div class="pt-nav-actions">
            <a href="index.php?ruta=admin" class="pt-admin-link" title="Acceso administrador" aria-label="Acceso administrador">
                <i class="ti ti-lock"></i>
            </a>
            <a href="index.php?ruta=paquetes" class="pt-btn">Reservar ahora</a>

            <button class="pt-burger" id="ptBurger" aria-label="Abrir menú" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>

    </div>
</nav>
<div class="pt-nav-overlay" id="ptOverlay"></div>
