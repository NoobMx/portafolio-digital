<?php

class DataBase {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = getenv('PGHOST') ?: 'localhost';
        $this->port = getenv('PGPORT') ?: '5432';
        $this->db_name = getenv('PGDATABASE') ?: 'personal_projectV2';
        $this->username = getenv('PGUSER') ?: 'postgres';
        $this->password = getenv('PGPASSWORD') ?: 'Olakase510';
    }

    public function getConnection() {
        $this->conn = null;
        try {
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