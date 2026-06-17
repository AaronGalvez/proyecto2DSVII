
<?php

// Router simple para el proyecto MVC.
// Lee controller/action desde la URL y ejecuta el método correspondiente.

$controllerParam = strtolower(trim($_GET['controller'] ?? 'admin'));
$action = trim($_GET['action'] ?? 'login');

$controladoresPermitidos = [
    'admin' => 'AdminController',
    'home' => 'HomeController',
    'contacto' => 'ContactoController',
    'paquete' => 'PaqueteController',
    'paquetes' => 'PaqueteController',
    'reserva' => 'ReservaController',
    'reservas' => 'ReservaController',
    // El archivo del repo aparece como GanaciasController.php, por eso se respeta ese nombre.
    'ganancias' => 'GanaciasController',
];

$controllerClass = $controladoresPermitidos[$controllerParam] ?? null;

if ($controllerClass === null) {
    http_response_code(404);
    echo 'Controlador no encontrado.';
    exit;
}

$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo 'Archivo de controlador no encontrado: ' . htmlspecialchars($controllerClass, ENT_QUOTES, 'UTF-8');
    exit;
}

require_once $controllerFile;

if (!class_exists($controllerClass)) {
    http_response_code(500);
    echo 'La clase del controlador no existe.';
    exit;
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Acción no encontrada.';
    exit;
}

$controller->$action();
