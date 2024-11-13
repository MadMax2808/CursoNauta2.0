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
        $query = "SELECT c.id_curso, c.titulo, c.activo, -- Añadimos c.activo aquí
                     COUNT(i.id_usuario) AS alumnos_inscritos, 
                     AVG(i.progreso) AS nivel_promedio, 
                     SUM(v.precio_pagado) AS ingresos_totales
              FROM Cursos c
              LEFT JOIN Inscripciones i ON c.id_curso = i.id_curso
              LEFT JOIN Ventas v ON c.id_curso = v.id_curso
              WHERE c.id_instructor = :userId
              GROUP BY c.id_curso";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalesPorPago($userId)
    {
        $query = "SELECT v.forma_pago, SUM(v.precio_pagado) AS total_ingresos
                  FROM Ventas v
                  JOIN Cursos c ON v.id_curso = c.id_curso
                  WHERE c.id_instructor = :userId
                  GROUP BY v.forma_pago";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetallesCurso($idCurso)
{
    $query = "SELECT u.nombre AS alumno, i.fecha_inscripcion, i.progreso, v.precio_pagado, v.forma_pago, c.titulo AS titulo
              FROM Inscripciones i
              JOIN Usuarios u ON i.id_usuario = u.idUsuario
              JOIN Ventas v ON i.id_curso = v.id_curso AND i.id_usuario = v.id_usuario
              JOIN Cursos c ON i.id_curso = c.id_curso
              WHERE i.id_curso = :idCurso";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getCatActivas() {
        try {
            $query = "SELECT id_categoria, nombre_categoria FROM Categorias WHERE activo = TRUE";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener categorías activas: " . $e->getMessage();
            return [];
        }
    }

    public function buscarVentasDinamico($categoriaID, $estado, $fechaInicio, $fechaFin, $usuarioID) {
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
