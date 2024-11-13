<?php
require_once 'Models/VentasModel.php';

class VentasController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new VentasModel($db);
    }

    public function obtenerVentas()
    {
        $userId = $_SESSION['user_id'];
        $cursosVentas = $this->model->getCursosVentas($userId);
        $totalesPorPago = $this->model->getTotalesPorPago($userId); // Filtra los totales por usuario
        return ['cursosVentas' => $cursosVentas, 'totalesPorPago' => $totalesPorPago];
    }


    public function obtenerDetallesCurso($idCurso)
    {
        return $this->model->getDetallesCurso($idCurso);
    }

    public function obtenerCategoriasActivas()
    {
        return $this->model->getCatActivas();
    }


    public function filtrarVentas($categoriaID, $estado, $fechaInicio, $fechaFin)
    {
        $userId = $_SESSION['user_id'];
        $cursosVentas = $this->model->buscarVentasDinamico( $categoriaID, $estado, $fechaInicio, $fechaFin, $userId);
        $totalesPorPago = $this->model->getTotalesPorPago($userId); // Filtra los totales por usuario

        return ['cursosVentas' => $cursosVentas, 'totalesPorPago' => $totalesPorPago];
    }
}
