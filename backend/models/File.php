<?php
class File {
    private $conn;

    // Declaración explícita para PHP 8.2+
    public $id_file;
    public $nombre;
    public $categoria;
    public $formato;
    public $emisor;
    public $fecha_emision;
    public $url;
    public $url_miniatura;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll($categoria = null) {
        if ($categoria) {
            $query = "SELECT * FROM files WHERE categoria = :categoria ORDER BY id_file DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':categoria', $categoria);
        } else {
            $query = "SELECT * FROM files ORDER BY id_file DESC";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOneByCategoria($categoria) {
        $query = "SELECT * FROM files WHERE categoria = :categoria ORDER BY id_file DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO files (nombre, categoria, formato, emisor, fecha_emision, url, url_miniatura) 
                  VALUES (:nombre, :categoria, :formato, :emisor, :fecha_emision, :url, :url_miniatura)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':formato', $this->formato);
        $stmt->bindParam(':emisor', $this->emisor);
        $stmt->bindParam(':fecha_emision', $this->fecha_emision);
        $stmt->bindParam(':url', $this->url);
        $stmt->bindParam(':url_miniatura', $this->url_miniatura);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE files 
                  SET nombre = :nombre, categoria = :categoria, formato = :formato, 
                      emisor = :emisor, fecha_emision = :fecha_emision, url = :url, url_miniatura = :url_miniatura 
                  WHERE id_file = :id_file";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':formato', $this->formato);
        $stmt->bindParam(':emisor', $this->emisor);
        $stmt->bindParam(':fecha_emision', $this->fecha_emision);
        $stmt->bindParam(':url', $this->url);
        $stmt->bindParam(':url_miniatura', $this->url_miniatura);
        $stmt->bindParam(':id_file', $this->id_file);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM files WHERE id_file = :id_file";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_file', $this->id_file);
        return $stmt->execute();
    }
}