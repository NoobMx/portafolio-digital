<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../config/conexion.php';

$db = new DataBase();
#$conexion = $db->connect();
$conexion = $db->getConnection();

if ($conexion) {
    echo json_encode([
        "status" => "success",
        "mensaje" => "¡Conexión a PostgreSQL exitosa!"
    ]);
}