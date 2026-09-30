<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new DataBase();
        $this->db = $database->connect();
        $this->user = new Usuario($this->db);
    }

    public function login() {
        // Leer los datos que enviará Vue
        $data = json_decode(file_get_contents("php://input"), true);
        
        $this->user->nickname = $data['user'] ?? '';
        $usuario = $this->user->read();

        // Verificamos si el usuario existe y si la contraseña (12345) coincide con el Hash de la BD
        if ($usuario && password_verify($data['password'], $usuario['psw'])) {
            return [
                "success" => true,
                "message" => "Login exitoso",
                "user" => [
                    "id" => $usuario['id_usuario'],
                    "nickname" => $usuario['nickname'],
                    "name" => $usuario['name_complete']
                ]
            ];
        } else {
            return [
                "success" => false,
                "message" => "Usuario o contraseña incorrectos"
            ];
        }
    }
}