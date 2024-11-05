<?php
require_once 'Models\Database.php';

class CursoModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function insertarCurso($titulo, $descripcion, $imagen, $costo, $niveles, $id_instructor, $id_categoria)
    {
        $query = "CALL InsertarCurso(:titulo, :descripcion, :imagen, :costo, :niveles, :id_instructor, :id_categoria, @p_id_curso)";
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':niveles', $niveles);
        $stmt->bindParam(':id_instructor', $id_instructor);
        $stmt->bindParam(':id_categoria', $id_categoria);

        if ($stmt->execute()) {
            $stmt->closeCursor();
            $result = $this->conn->query("SELECT @p_id_curso AS id_curso")->fetch(PDO::FETCH_ASSOC);
            return $result['id_curso'];
        }
        return false;
    }

    public function insertarNivel($id_curso, $numero_nivel, $titulo_nivel, $video, $contenido, $archivos, $costo)
    {
        $query = "CALL InsertarNivel(:id_curso, :numero_nivel, :titulo_nivel, :video, :contenido, :archivos, :costo)";
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':id_curso', $id_curso);
        $stmt->bindParam(':numero_nivel', $numero_nivel);
        $stmt->bindParam(':titulo_nivel', $titulo_nivel);
        $stmt->bindParam(':video', $video, PDO::PARAM_LOB);
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':archivos', $archivos, PDO::PARAM_LOB);
        $stmt->bindParam(':costo', $costo);

        return $stmt->execute();
    }
    public function obtenerCursos()
    {
        $query = "
            SELECT cursos.id_curso, cursos.titulo, cursos.descripcion, cursos.activo, usuarios.nombre AS instructor_nombre
            FROM cursos
            JOIN usuarios ON cursos.id_instructor = usuarios.idUsuario
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoCurso($idCurso, $nuevoEstado)
    {
        $query = "UPDATE cursos SET activo = :nuevoEstado WHERE id_curso = :idCurso";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_INT);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
