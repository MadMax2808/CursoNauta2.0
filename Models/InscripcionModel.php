<?php
require_once 'Models\Database.php';

class InscripcionModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function registrarInscripcion($idCurso, $idUsuario)
    {
        try {
            $stmt = $this->conn->prepare("CALL RegistrarInscripcion(:id_curso, :id_usuario)");
            $stmt->bindParam(':id_curso', $idCurso, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error al registrar la inscripción: " . $e->getMessage();
            return false;
        }
    }
    public function obtenerCursosInscritos($idUsuario) {
        try {
            $query = "
                SELECT i.*, c.titulo AS curso_titulo, cat.nombre_categoria AS categoria
                FROM Inscripciones i
                JOIN Cursos c ON i.id_curso = c.id_curso
                JOIN Categorias cat ON c.id_categoria = cat.id_categoria
                WHERE i.id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los cursos inscritos: " . $e->getMessage();
            return [];
        }
    }
    
}
