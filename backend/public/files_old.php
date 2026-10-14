<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/File.php';

$database = new DataBase();
#$db = $database->connect();
$db = $database->getConnection();
$fileModel = new File($db);

$method = $_SERVER['REQUEST_METHOD'];

// CASO GET: Para leer datos (Desde el portafolio público o el admin)
if ($method === 'GET') {
    $tipo = $_GET['tipo'] ?? '';
    
    if ($tipo === 'cv') {
        // El CV es único, usamos readByTipo
        $resultado = $fileModel->readByTipo('cv');
    } else {
        // Las certificaciones son muchas, usamos readAllByTipo
        $resultado = $fileModel->readAllByTipo('certificacion');
    }

    echo json_encode(["success" => true, "data" => $resultado]);
    exit;
}

// CASO POST: Para actualizar la URL (Desde tu panel de administración)
if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id_file']) || !isset($data['url'])) {
        echo json_encode(["success" => false, "message" => "Datos incompletos."]);
        exit;
    }

    $fileModel->id_file = $data['id_file'];
    $fileModel->url = $data['url'];
    $fileModel->nombre = $data['nombre'] ?? 'Archivo';

    if ($fileModel->updateUrl()) {
        echo json_encode(["success" => true, "message" => "Archivo actualizado con éxito."]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo actualizar."]);
    }
    exit;
}