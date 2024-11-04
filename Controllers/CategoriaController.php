<?php
require_once 'Models\Database.php';
require_once 'Models\CategoriaModel.php';

$controller = new CategoriaController();
$controller->gestionarSolicitud();

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->categoriaModel = new CategoriaModel($db);
    }
    public function gestionarSolicitud()
    {
        // Verifica si 'action' existe en POST
        $action = $_POST['action'] ?? null;

        if ($action === 'add') {
            $this->agregarCategoria();
        } elseif ($action === 'edit') {
            // $this->modificarCategoria();
        } else {
           // echo "Acción no válida.";
        }
    }
    public function agregarCategoria()
    {
        $nombre_categoria = $_POST["nombre_categoria"] ?? null;
        $descripcion = $_POST["descripcion"] ?? null;
        $id_creador = $_POST["id_creador"] ?? null; // Aquí es donde obtienes el userId del formulario

        if ($nombre_categoria && $descripcion && $id_creador) {
            $resultado = $this->categoriaModel->registrarCategoria($nombre_categoria, $descripcion, $id_creador);

            if ($resultado) {
                echo "Categoría registrada con éxito.";
                header("Location: index.php?page=Admi");
                exit();
            } else {
                echo "Error al registrar la categoría.";
            }
        } else {
            echo "Datos incompletos.";
        }
    }
    public function mostrarCategorias($id_creador)
    {
        $categorias = $this->categoriaModel->obtenerCategorias($id_creador);
        return $categorias;
    }
}
