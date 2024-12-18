<?php
require_once 'Models/CursoModel.php';

class CursoController
{
    private $cursoModel;

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
    }
    public function agregarCurso()
    {
        session_start();
        $titulo = $_POST['course_title'];
        $descripcion = $_POST['course_description'];
        $imagen = isset($_FILES['course_image']['tmp_name']) && is_string($_FILES['course_image']['tmp_name'])
            ? file_get_contents($_FILES['course_image']['tmp_name'])
            : null;

        $costo = $_POST['course_price'];
        $niveles = $_POST['levels'];
        $id_instructor = $_SESSION['user_id'];
        $id_categoria = $_POST['course_category'];

        // Insertar el curso
        $id_curso = $this->cursoModel->insertarCurso($titulo, $descripcion, $imagen, $costo, $niveles, $id_instructor, $id_categoria);

        if ($id_curso) {
            // Insertar cada nivel
            for ($i = 1; $i <= $niveles; $i++) {
                $titulo_nivel = $_POST["level_title_$i"];
                $video = isset($_FILES["level_video_$i"]['tmp_name']) && is_string($_FILES["level_video_$i"]['tmp_name'])
                    ? file_get_contents($_FILES["level_video_$i"]['tmp_name'])
                    : null;

                $contenido = $_POST["level_content_$i"];

                $archivos = isset($_FILES["level_attachments_$i"]['tmp_name']) && is_string($_FILES["level_attachments_$i"]['tmp_name'])
                    ? file_get_contents($_FILES["level_attachments_$i"]['tmp_name'])
                    : null;
                // print_r($_FILES);

                $costo_nivel = $_POST['level_price'] ?: 0; // Puedes usar un valor predeterminado

                $this->cursoModel->insertarNivel($id_curso, $i, $titulo_nivel, $video, $contenido, $archivos, $costo_nivel);
            }

            header("Location: index.php?page=Ventas");
            exit;
        } else {
            echo "Error al agregar el curso.";
        }
    }
    public function mostrarCursos()
    {
        return $this->cursoModel->obtenerCursos();
    }

    public function cambiarEstadoCurso()
    {
        if (isset($_POST['idCurso']) && isset($_POST['nuevoEstado'])) {
            $idCurso = $_POST['idCurso'];
            $nuevoEstado = $_POST['nuevoEstado'];
            $this->cursoModel->actualizarEstadoCurso($idCurso, $nuevoEstado);
        }
    }

    public function obtenerCursoPorId($idCurso)
    {
        return $this->cursoModel->obtenerCursoPorId($idCurso);
    }

    public function obtenerNivelesPorCurso($idCurso)
    {
        return $this->cursoModel->obtenerNivelesPorCurso($idCurso);
    }
    public function obtenerValoracionPromedio($idCurso)
    {
        return $this->cursoModel->obtenerValoracionPromedio($idCurso);
    }

    public function obtenerComentarios($idCurso)
    {
        return $this->cursoModel->obtenerComentarios($idCurso);
    }

    public function verificarCompraCurso($idCurso, $idUsuario)
    {
        return $this->cursoModel->verificarCompraCurso($idCurso, $idUsuario);
    }
    public function actualizarProgresoCurso($idCurso, $idUsuario, $nuevoProgreso)
    {
        $progresoActual = $this->cursoModel->obtenerProgreso($idCurso, $idUsuario);

        // Si el progreso ya es 100, no actualizamos más
        if ($progresoActual >= 100) {
            echo "<script>alert('Curso Finalizado, genere certificado en Kardex');</script>";
            return false;
        }
        return $this->cursoModel->actualizarProgreso($idCurso, $idUsuario, $nuevoProgreso);
    }

    public function obtenerProgresoCurso($idCurso, $idUsuario)
    {
        return $this->cursoModel->obtenerProgreso($idCurso, $idUsuario);
    }

    public function eliminarComentario()
    {
        if (isset($_POST['idComentario']) && isset($_POST['motivo']) && isset($_POST['idCurso'])) {
            $idComentario = $_POST['idComentario'];
            $motivo = $_POST['motivo'];
            $idCurso = $_POST['idCurso'];

            if ($this->cursoModel->eliminarComentario($idComentario, $motivo)) {
                header("Location: index.php?page=Curso&idCurso=" . $idCurso);
            } else {
                echo "Error al eliminar el comentario.";
            }
        }
    }

    public function editarCurso()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Debug: Verifica si el ID es válido
        if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "Debug: ID de curso no válido.<br>";
            exit;
        }
    
        $id_curso = (int) $_GET['id'];
        echo "Debug: ID del curso recibido: $id_curso<br>";
    
        // Debug: Verifica si se reciben los datos del formulario
        if (!isset($_POST['course_title']) || !isset($_POST['course_description'])) {
            echo "Debug: Datos del formulario no recibidos.<br>";
            exit;
        }
    
        $titulo = $_POST['course_title'];
        $descripcion = $_POST['course_description'];
        $imagen = isset($_FILES['course_image']['tmp_name']) && !empty($_FILES['course_image']['tmp_name'])
            ? file_get_contents($_FILES['course_image']['tmp_name'])
            : null; // Enviar NULL si no se actualiza la imagen
    
        echo "Debug: Datos del formulario - Título: $titulo, Descripción: $descripcion<br>";
    
        $costo = $_POST['course_price'];
        $id_categoria = $_POST['course_category'];
    
        // Debug: Verifica antes de actualizar
        echo "Debug: Preparando para actualizar el curso.<br>";
    
        $resultado = $this->cursoModel->actualizarCurso($id_curso, $titulo, $descripcion, $imagen, $costo, $id_categoria);
    
        // Debug: Resultado de la actualización
        if ($resultado) {
            echo "Debug: Curso actualizado exitosamente.<br>";
        } else {
            echo "Debug: Falló la actualización del curso.<br>";
            exit;
        }
    
        // Debug: Iteración sobre niveles
        $niveles = (int) $_POST['levels'];
        echo "Debug: Número de niveles a actualizar: $niveles<br>";
        for ($i = 1; $i <= $niveles; $i++) {
            echo "Debug: Procesando nivel $i<br>";
            if (!isset($_POST["level_title_$i"]) || !isset($_POST["level_content_$i"])) {
                echo "Debug: Datos faltantes para el nivel $i<br>";
                continue;
            }
            $id_nivel = $_POST["level_id_$i"];
            $titulo_nivel = $_POST["level_title_$i"];
            $contenido = $_POST["level_content_$i"];
            $costo_nivel = $_POST["level_price_$i"];
    
            echo "Debug: Nivel $i - Título: $titulo_nivel, Contenido: $contenido, Costo: $costo_nivel<br>";
    
            $this->cursoModel->actualizarNivel($id_nivel, $titulo_nivel, $contenido, $costo_nivel);
        }
    
        // Redirige después de la actualización
        echo '<script>window.location.href = "index.php?page=Ventas";</script>';
        exit;
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new CursoController();
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'agregarCurso':
                $controlador->agregarCurso();
                break;
            case 'cambiarEstadoCurso':
                $controlador->cambiarEstadoCurso();
                break;
            case 'actualizarProgreso':
                $idUsuario = $_SESSION['user_id'];
                $idCurso = intval($_POST['idCurso']);
                $nuevoProgreso = floatval($_POST['progreso']);
                $controlador->actualizarProgresoCurso($idCurso, $idUsuario, $nuevoProgreso);
                break;
            case 'eliminarComentario':
                $controlador->eliminarComentario();
                break;
            case 'editarCurso':
                $controlador->editarCurso();
                break;
        }
    }
}
