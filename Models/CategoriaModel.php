<?php
class CategoriaModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrarCategoria($nombre_categoria, $descripcion, $id_creador)
    {
        try {
            $sql = "CALL RegistrarCategoria(:nombre_categoria, :descripcion, :id_creador)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":nombre_categoria", $nombre_categoria);
            $stmt->bindParam(":descripcion", $descripcion);
            $stmt->bindParam(":id_creador", $id_creador);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al registrar la categoría: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerCategorias($id_creador)
    {
        try {
            $sql = "CALL ObtenerCategorias(:id_creador)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_creador', $id_creador, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener las categorías: " . $e->getMessage();
            return false;
        }
    }

    public function getAllCategorias()
    {
        try {
            $sql = "CALL GetAllCategorias()";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener todas las categorías: " . $e->getMessage();
            return false;
        }
    }

    // Método para actualizar el nombre y la descripción de una categoría
    public function actualizarCategoria($id_categoria, $nombre_categoria, $descripcion)
    {
        $sql = "CALL ActualizarCategoria(:id_categoria, :nombre_categoria, :descripcion)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_categoria', $nombre_categoria);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    }

    // Método para cambiar el estado de una categoría (activar/desactivar)
    public function cambiarEstadoCategoria($id_categoria, $nuevoEstado)
    {
        $sql = "CALL CambiarEstadoCategoria(:id_categoria, :nuevoEstado)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_BOOL);
        return $stmt->execute();
    }
}
