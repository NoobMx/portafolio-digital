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
require_once __DIR__ . '/../models/Proyecto.php';

$database = new DataBase();
$db = $database->connect();
$proyecto = new Proyecto($db);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    echo json_encode(["success" => true, "data" => $proyecto->readAll()]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if ($method === 'POST') {
    if (empty($data['titulo']) || empty($data['tecnologias'])) {
        echo json_encode(["success" => false, "message" => "Título y Tecnologías son requeridos."]);
        exit;
    }
    
    $proyecto->titulo = $data['titulo'];
    $proyecto->descripcion = $data['descripcion'] ?? '';
    $proyecto->tecnologias = $data['tecnologias'];
    $proyecto->url_imagen = !empty($data['url_imagen']) ? $data['url_imagen'] : 'https://via.placeholder.com/300x200';
    $proyecto->url_github = $data['url_github'] ?? '';

    if ($proyecto->create()) {
        echo json_encode(["success" => true, "message" => "Proyecto creado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar en la base de datos."]);
    }
    exit;
}

if ($method === 'PUT') {
    if (empty($data['id_proyecto']) || empty($data['titulo'])) {
        echo json_encode(["success" => false, "message" => "ID y Título son requeridos para actualizar."]);
        exit;
    }

    $proyecto->id_proyecto = $data['id_proyecto'];
    $proyecto->titulo = $data['titulo'];
    $proyecto->descripcion = $data['descripcion'] ?? '';
    $proyecto->tecnologias = $data['tecnologias'];
    $proyecto->url_imagen = !empty($data['url_imagen']) ? $data['url_imagen'] : 'https://via.placeholder.com/300x200';
    $proyecto->url_github = $data['url_github'] ?? '';

    if ($proyecto->update()) {
        echo json_encode(["success" => true, "message" => "Proyecto actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el proyecto."]);
    }
    exit;
}

if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        echo json_encode(["success" => false, "message" => "ID no proporcionado."]);
        exit;
    }

    $proyecto->id_proyecto = $id;

    if ($proyecto->delete()) {
        echo json_encode(["success" => true, "message" => "Proyecto eliminado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo eliminar el proyecto."]);
    }
    exit;
}