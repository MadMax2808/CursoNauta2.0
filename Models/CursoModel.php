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
        $sql = "CALL ObtenerCursos()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoCurso($idCurso, $nuevoEstado)
    {
        $sql = "CALL ActualizarEstadoCurso(:idCurso, :nuevoEstado)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerCursoPorId($idCurso)
    {
        $sql = "CALL ObtenerCursoPorId(:idCurso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerNivelesPorCurso($idCurso)
    {
        $sql = "CALL obtenerNivelesPorCurso(:idCurso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerValoracionPromedio($idCurso)
    {
        // Calcula el promedio usando la función almacenada
        $stmt = $this->conn->prepare("SELECT obtenerPromedioCurso(?) AS promedio");
        $stmt->execute([$idCurso]);
        $result = $stmt->fetch();
        $promedio = $result['promedio'] ?? 0;

        // Actualiza la columna calificacion_promedio en la tabla Cursos
        $updateStmt = $this->conn->prepare("UPDATE Cursos SET calificacion_promedio = ? WHERE id_curso = ?");
        $updateStmt->execute([$promedio, $idCurso]);

        return $promedio;
    }


    public function obtenerComentarios($idCurso)
    {
        $sql = "CALL ObtenerComentariosPorCurso(:idCurso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function eliminarComentario($idComentario, $motivoEliminacion)
    {
        $sql = "CALL eliminarComentarioPorId(:idComentario, :motivoEliminacion)";
        $stmt = $this->conn->prepare($sql);

        // Vincular parámetros
        $stmt->bindParam(':idComentario', $idComentario, PDO::PARAM_INT);
        $stmt->bindParam(':motivoEliminacion', $motivoEliminacion, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function verificarCompraCurso($idCurso, $idUsuario)
    {
        $sql = "CALL VerificarCompraCursoPorUsuario(:idCurso, :idUsuario, @resultado)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el valor del resultado
        $stmt = $this->conn->prepare("SELECT @resultado");
        $stmt->execute();
        $resultado = $stmt->fetchColumn();

        return $resultado > 0; // Retorna true si el usuario compró el curso
    }

    public function actualizarProgreso($idCurso, $idUsuario, $nuevoProgreso)
    {
        $sql = "CALL ActualizarProgresoCurso(:idCurso, :idUsuario, :nuevoProgreso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':nuevoProgreso', $nuevoProgreso, PDO::PARAM_STR); // Usamos DECIMAL para el progreso
        return $stmt->execute();
    }

    public function obtenerProgreso($idCurso, $idUsuario)
    {
        $sql = "CALL obtenerProgresoPorCursoYUsuario(:idCurso, :idUsuario, @progreso)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el valor del progreso
        $stmt = $this->conn->prepare("SELECT @progreso");
        $stmt->execute();
        $progreso = $stmt->fetchColumn();

        return $progreso; // Devuelve el progreso o 0 si no existe
    }

    public function actualizarCurso($id_curso, $titulo, $descripcion, $imagen, $costo, $id_categoria)
    {
        $query = "CALL ActualizarCurso(:id_curso, :titulo, :descripcion, :imagen, :costo, :id_categoria)";
        $stmt = $this->conn->prepare($query);

        // Vincular parámetros
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
        $stmt->bindParam(':costo', $costo);
        $stmt->bindParam(':id_categoria', $id_categoria);

        return $stmt->execute();
    }

    public function actualizarNivel($id_nivel, $titulo_nivel, $contenido, $costo)
    {
        $query = "CALL ActualizarNivel(:id_nivel, :titulo_nivel, :contenido, :costo)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_nivel', $id_nivel);
        $stmt->bindParam(':titulo_nivel', $titulo_nivel);
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':costo', $costo);

        return $stmt->execute();
    }
}
