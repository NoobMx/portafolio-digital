<?php

class Usuario {
    private $conn;
    public $nickname;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        // Usamos sentencias preparadas (PDO) para evitar Inyección SQL
        $query = "SELECT * FROM usuarios WHERE nickname = :nickname LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nickname', $this->nickname);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}