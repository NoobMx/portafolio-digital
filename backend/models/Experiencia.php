<?php
class Experiencia {
    private $conn;

    // Declaración explícita
    public $id_experiencia;
    public $tipo;
    public $titulo;
    public $institucion_empresa;
    public $fecha_inicio;
    public $fecha_fin;
    public $descripcion;
    public $actual;
    public $orden; // <-- Nueva propiedad

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. LEER TODOS (Primero por secuencia 'orden', luego por fecha)
    public function readAll() {
        $query = "SELECT * FROM experiencia ORDER BY orden ASC, fecha_inicio DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LEER UN REGISTRO ESPECÍFICO POR ID (El método GET que faltaba)
    public function readOne() {
        $query = "SELECT * FROM experiencia WHERE id_experiencia = :id_experiencia LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_experiencia', $this->id_experiencia);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : null; // Retorna el registro o null si no existe
    }

    // 2. CREAR
    public function create() {
        $query = "INSERT INTO experiencia (tipo, titulo, institucion_empresa, fecha_inicio, fecha_fin, descripcion, actual, orden) 
                  VALUES (:tipo, :titulo, :institucion_empresa, :fecha_inicio, :fecha_fin, :descripcion, :actual, :orden)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':institucion_empresa', $this->institucion_empresa);
        $stmt->bindParam(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindParam(':fecha_fin', $this->fecha_fin);
        $stmt->bindParam(':descripcion', $this->descripcion);
        
        $actual_val = $this->actual ? 1 : 0;
        $stmt->bindParam(':actual', $actual_val, PDO::PARAM_INT);
        $stmt->bindParam(':orden', $this->orden, PDO::PARAM_INT); // <-- Bind del orden

        return $stmt->execute();
    }

    // 3. ACTUALIZAR
    public function update() {
        $query = "UPDATE experiencia 
                  SET tipo = :tipo, titulo = :titulo, institucion_empresa = :institucion_empresa, 
                      fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, descripcion = :descripcion, 
                      actual = :actual, orden = :orden 
                  WHERE id_experiencia = :id_experiencia";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':institucion_empresa', $this->institucion_empresa);
        $stmt->bindParam(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindParam(':fecha_fin', $this->fecha_fin);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $actual_val = $this->actual ? 1 : 0;
        $stmt->bindParam(':actual', $actual_val, PDO::PARAM_INT);
        $stmt->bindParam(':orden', $this->orden, PDO::PARAM_INT); // <-- Bind del orden
        $stmt->bindParam(':id_experiencia', $this->id_experiencia);

        return $stmt->execute();
    }

    // 4. ELIMINAR
    public function delete() {
        $query = "DELETE FROM experiencia WHERE id_experiencia = :id_experiencia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_experiencia', $this->id_experiencia);
        return $stmt->execute();
    }
}