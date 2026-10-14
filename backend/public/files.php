<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/File.php';

$database = new DataBase();
$db = $database->connect();
$fileModel = new File($db);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $categoria = $_GET['categoria'] ?? null;
    $single = $_GET['single'] ?? false;

    if ($single && $categoria) {
        $data = $fileModel->readOneByCategoria($categoria);
        echo json_encode(["success" => true, "data" => $data]);
    } else {
        $data = $fileModel->readAll($categoria);
        echo json_encode(["success" => true, "data" => $data]);
    }
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if ($method === 'POST') {
    if (empty($data['nombre']) || empty($data['categoria']) || empty($data['url'])) {
        echo json_encode(["success" => false, "message" => "Nombre, Categoría y URL son requeridos."]);
        exit;
    }

    $fileModel->nombre = $data['nombre'];
    $fileModel->categoria = $data['categoria'];
    $fileModel->formato = $data['formato'] ?? 'pdf';
    $fileModel->emisor = $data['emisor'] ?? '';
    $fileModel->fecha_emision = $data['fecha_emision'] ?? null;
    $fileModel->url = $data['url'];
    $fileModel->url_miniatura = $data['url_miniatura'] ?? '';

    if ($fileModel->create()) {
        echo json_encode(["success" => true, "message" => "Archivo guardado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar el archivo."]);
    }
    exit;
}

if ($method === 'PUT') {
    if (empty($data['id_file']) || empty($data['nombre'])) {
        echo json_encode(["success" => false, "message" => "ID y Nombre son requeridos para actualizar."]);
        exit;
    }

    $fileModel->id_file = $data['id_file'];
    $fileModel->nombre = $data['nombre'];
    $fileModel->categoria = $data['categoria'];
    $fileModel->formato = $data['formato'] ?? 'pdf';
    $fileModel->emisor = $data['emisor'] ?? '';
    $fileModel->fecha_emision = $data['fecha_emision'] ?? null;
    $fileModel->url = $data['url'];
    $fileModel->url_miniatura = $data['url_miniatura'] ?? '';

    if ($fileModel->update()) {
        echo json_encode(["success" => true, "message" => "Archivo actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el archivo."]);
    }
    exit;
}

if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode(["success" => false, "message" => "ID no proporcionado."]);
        exit;
    }

    $fileModel->id_file = $id;

    if ($fileModel->delete()) {
        echo json_encode(["success" => true, "message" => "Archivo eliminado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo eliminar el archivo."]);
    }
    exit;
}