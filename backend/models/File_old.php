<?php
class File {
    private $conn;
    public $id_file;
    public $nombre;
    public $url;
    public $tipo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener un archivo específico por su tipo (ideal para el CV)
    public function readByTipo($tipo) {
        $query = "SELECT * FROM files WHERE tipo = :tipo LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los archivos de una categoría (ideal para las Certificaciones)
    public function readAllByTipo($tipo) {
        $query = "SELECT * FROM files WHERE tipo = :tipo ORDER BY id_file DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar la URL de un archivo existente
    public function updateUrl() {
        $query = "UPDATE files SET url = :url, nombre = :nombre WHERE id_file = :id_file";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':url', $this->url);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':id_file', $this->id_file);
        
        return $stmt->execute();
    }
}