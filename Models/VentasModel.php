<?php
class VentasModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCursosVentas($userId)
    {
        try {
            // Preparar y ejecutar el procedimiento almacenado
            $query = "CALL GetCursosVentas(:userId)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            // Retornar los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los cursos y ventas: " . $e->getMessage();
            return [];
        }
    }

    public function getTotalesPorPago($userId)
    {
        try {
            // Preparar y ejecutar el procedimiento almacenado
            $query = "CALL GetTotalesPorPago(:userId)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            // Retornar los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los totales por pago: " . $e->getMessage();
            return [];
        }
    }

    public function getDetallesCurso($idCurso)
    {
        try {
            // Preparar y ejecutar el procedimiento almacenado
            $query = "CALL GetDetallesCurso(:idCurso)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
            $stmt->execute();

            // Retornar los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los detalles del curso: " . $e->getMessage();
            return [];
        }
    }

    public function getCatActivas()
    {
        try {
            $query = "CALL ObtenerCategoriasActivas()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener categorías activas: " . $e->getMessage();
            return [];
        }
    }

    public function buscarVentasDinamico($categoriaID, $estado, $fechaInicio, $fechaFin, $usuarioID)
    {
        try {
            $query = $this->conn->prepare("CALL BuscarVentasDinamico(:categoriaID, :estado, :fechaInicio, :fechaFin, :usuarioID)");

            // Asignar valores a los parámetros
            $query->bindParam(':categoriaID', $categoriaID, PDO::PARAM_INT);
            $query->bindParam(':estado', $estado, PDO::PARAM_STR);
            $query->bindParam(':fechaInicio', $fechaInicio, PDO::PARAM_STR); // Se asume formato 'YYYY-MM-DD'
            $query->bindParam(':fechaFin', $fechaFin, PDO::PARAM_STR);
            $query->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);

            $query->execute();

            // Obtener los resultados
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
