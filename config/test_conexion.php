<?php

require_once "database.php";

$db = new Database();

$conexion = $db->conectar();

echo "Conexión exitosa";