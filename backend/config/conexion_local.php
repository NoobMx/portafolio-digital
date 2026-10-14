<?php

class DataBase {
    private $host = "localhost";
    private $port = "5432";
    private $db_name = "personal_projectV2";
    private $username = "postgres";
    private $password = "Olakase510";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $dsn = "pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $exception) {
            http_response_code(500);
            echo json_encode(["error" => "Error de conexión a la BD: " . $exception->getMessage()]);
            exit;
        }

        return $this->conn;
    }
}