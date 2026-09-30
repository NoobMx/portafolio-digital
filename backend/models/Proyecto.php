<?php
class Proyecto {
    private $conn;

    // ¡ESTA ES LA PARTE CLAVE QUE EXIGE PHP 8.2+!
    // Tenemos que declarar explícitamente las variables aquí arriba.
    public $id_proyecto;
    public $titulo;
    public $descripcion;
    public $tecnologias;
    public $url_imagen;
    public $url_github;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. LEER TODOS
    public function readAll() {
        $query = "SELECT * FROM proyectos ORDER BY id_proyecto DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. CREAR NUEVO
    public function create() {
        $query = "INSERT INTO proyectos (titulo, descripcion, tecnologias, url_imagen, url_github) 
                  VALUES (:titulo, :descripcion, :tecnologias, :url_imagen, :url_github)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':tecnologias', $this->tecnologias);
        $stmt->bindParam(':url_imagen', $this->url_imagen);
        $stmt->bindParam(':url_github', $this->url_github);

        return $stmt->execute();
    }

    // 3. ACTUALIZAR EXISTENTE
    public function update() {
        $query = "UPDATE proyectos 
                  SET titulo = :titulo, descripcion = :descripcion, tecnologias = :tecnologias, 
                      url_imagen = :url_imagen, url_github = :url_github 
                  WHERE id_proyecto = :id_proyecto";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':tecnologias', $this->tecnologias);
        $stmt->bindParam(':url_imagen', $this->url_imagen);
        $stmt->bindParam(':url_github', $this->url_github);
        $stmt->bindParam(':id_proyecto', $this->id_proyecto);

        return $stmt->execute();
    }

    // 4. ELIMINAR
    public function delete() {
        $query = "DELETE FROM proyectos WHERE id_proyecto = :id_proyecto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_proyecto', $this->id_proyecto);
        return $stmt->execute();
    }
}