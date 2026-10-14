<?php
header('Content-Type: application/json');
// ¡Aquí está el cambio principal!
header("Access-Control-Allow-Origin: *"); 
// Ampliamos los métodos y headers permitidos por si acaso
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../controllers/AuthController.php';

$authController = new AuthController();
echo json_encode($authController->login());