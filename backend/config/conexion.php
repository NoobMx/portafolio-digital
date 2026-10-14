<?php

class DataBase {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    // Cuando se cree la conexión, decidirá si usa Railway o tu PC local
    public function __construct() {
        $this->host = getenv('PGHOST') ?: 'localhost';
        $this->port = getenv('PGPORT') ?: '5432';
        $this->db_name = getenv('PGDATABASE') ?: 'tu_base_local'; // Pon aquí el nombre de tu BD local
        $this->username = getenv('PGUSER') ?: 'postgres';
        $this->password = getenv('PGPASSWORD') ?: 'tu_password_local'; // Pon tu contraseña de pgAdmin aquí
    }

    public function getConnection() {
        $this->conn = null;
        try {
            // Nota que usamos pgsql: porque es PostgreSQL
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo json_encode(["success" => false, "message" => "Error de conexión a la BD: " . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}