<?php
require_once 'Models/InscripcionModel.php';

class InscripcionController
{
    private $inscripcionModel;

    public function __construct()
    {
        $this->inscripcionModel = new InscripcionModel();
    }

    public function registrar()
    {
        session_start();
        $idCurso = isset($_POST['idCurso']) ? (int)$_POST['idCurso'] : 0;
        $idUsuario = $_SESSION['user_id'];

        if ($idCurso > 0 && $idUsuario) {
            $resultado = $this->inscripcionModel->registrarInscripcion($idCurso, $idUsuario);
            if ($resultado) {
                echo "<script>
                alert('¡Se Agrego Tu Curso Al Kardex!');
                window.location.href = 'index.php?page=Kardex'; // Redirige a una página de confirmación o a donde desees
              </script>";
            } else {
                echo "Error al registrar la inscripción.";
            }
        } else {
            echo "Datos de inscripción inválidos.";
        }
    }

    public function mostrarCursosInscritos()
    {
        $idUsuario = $_SESSION['user_id'];
        return $this->inscripcionModel->obtenerCursosInscritos($idUsuario); // Asegúrate de devolver el resultado
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new InscripcionController();
    if (isset($_POST['action']) && $_POST['action'] === 'registrarInscripcion') {
        $controlador->registrar();
    }
}
