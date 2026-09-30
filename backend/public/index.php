<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Content-Type: application/json");

require_once __DIR__ . '/../config/conexion.php';

$db = new DataBase();
$conexion = $db->connect();

if ($conexion) {
    echo json_encode([
        "status" => "success",
        "mensaje" => "¡Conexión a PostgreSQL exitosa!"
    ]);
}