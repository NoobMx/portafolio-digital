<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Experiencia.php';

$database = new DataBase();
$db = $database->connect();
$experiencia = new Experiencia($db);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Si nos pasan un ID por la URL, buscamos solo ese registro
    if (isset($_GET['id'])) {
        $experiencia->id_experiencia = $_GET['id'];
        $resultado = $experiencia->readOne();
        
        if ($resultado) {
            echo json_encode(["success" => true, "data" => $resultado]);
        } else {
            echo json_encode(["success" => false, "message" => "Registro no encontrado."]);
        }
    } else {
        // Si no hay ID, devolvemos todos los registros
        echo json_encode(["success" => true, "data" => $experiencia->readAll()]);
    }
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if ($method === 'POST') {
    if (empty($data['titulo']) || empty($data['institucion_empresa'])) {
        echo json_encode(["success" => false, "message" => "Título y Empresa/Institución son requeridos."]);
        exit;
    }
    
    $experiencia->tipo = $data['tipo'] ?? 'experiencia';
    $experiencia->titulo = $data['titulo'];
    $experiencia->institucion_empresa = $data['institucion_empresa'];
    $experiencia->fecha_inicio = $data['fecha_inicio'];
    $experiencia->fecha_fin = !empty($data['fecha_fin']) ? $data['fecha_fin'] : null;
    $experiencia->descripcion = $data['descripcion'] ?? '';
    $experiencia->actual = isset($data['actual']) ? (bool)$data['actual'] : false;
    
    // Capturamos el nuevo campo
    $experiencia->orden = isset($data['orden']) ? (int)$data['orden'] : 0;

    if ($experiencia->create()) {
        echo json_encode(["success" => true, "message" => "Registro guardado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar."]);
    }
    exit;
}