<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SVentas.css">

<?php include 'Views\Parciales\Nav.php';

require_once 'Controllers/VentasController.php';

$database = new Database();
$db = $database->getConnection();

$ventasController = new VentasController($db);

// Captura de filtros
$categoriaID = isset($_GET['categoria']) && $_GET['categoria'] !== 'all' ? intval($_GET['categoria']) : null;
$estado = isset($_GET['estado']) && $_GET['estado'] !== 'all' ? $_GET['estado'] : null;
$fechaInicio = !empty($_GET['start_date']) ? $_GET['start_date'] : null;
$fechaFin = !empty($_GET['end_date']) ? $_GET['end_date'] : null;


$data = ($categoriaID || $estado || $fechaInicio || $fechaFin)
    ? $ventasController->filtrarVentas($categoriaID, $estado, $fechaInicio, $fechaFin,)
    : $ventasController->obtenerVentas();

$cursosVentas = $data['cursosVentas'];
$totalesPorPago = $data['totalesPorPago'];

$categoriasActivas = $ventasController->obtenerCategoriasActivas();

// Verificar si se seleccionó un curso
$detallesCurso = [];
$totalIngresosCurso = 0;
if (isset($_GET['idCurso'])) {
    $idCurso = (int)$_GET['idCurso'];
    $detallesCurso = $ventasController->obtenerDetallesCurso($idCurso);

    foreach ($detallesCurso as $detalle) {
        $totalIngresosCurso += $detalle['precio_pagado'];
    }
}
?>

<?php
require_once 'Controllers/CursoController.php';

$cursoController = new CursoController();
$cursos = $cursoController->mostrarCursos();
$cursoController->cambiarEstadoCurso();
?>
<!-- Lista Ventas -->
<div class="container">

    <div class="kardex-section">
        <!-- Filtros -->
        <div class="filters">
            <h3>Filtrar cursos</h3>
            <form action="index.php" method="GET">
                <!-- Especifica la página para que redirija correctamente -->
                <input type="hidden" name="page" value="Ventas">

                <!-- Rango de Fechas -->
                <div class="filter-date">
                    <label for="start-date">Fecha de creación (inicio)</label>
                    <input type="date" id="start-date" name="start_date" value="<?= htmlspecialchars($fechaInicio) ?>">
                    <label for="end-date">Fecha de creación (fin)</label>
                    <input type="date" id="end-date" name="end_date" value="<?= htmlspecialchars($fechaFin) ?>">
                </div>

                <!-- Categoría -->
                <div class="filter-category">
                    <label for="category">Categoría</label>
                    <select id="category" name="categoria">
                        <option value="all">Todas las categorías</option>
                        <?php foreach ($categoriasActivas as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria['id_categoria']) ?>" <?= $categoriaID == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categoria['nombre_categoria']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Estado del Curso -->
                <div class="filter-status">
                    <label for="estado">Estado del Curso</label>
                    <select id="estado" name="estado">
                        <option value="all" <?= $estado == null ? 'selected' : '' ?>>Todos</option>
                        <option value="activo" <?= $estado === 'activo' ? 'selected' : '' ?>>Solo cursos activos</option>
                        <option value="inactivo" <?= $estado === 'inactivo' ? 'selected' : '' ?>>Solo cursos inactivos</option>
                    </select>
                </div>

                <!-- Aplicar Filtros -->
                <button type="submit" class="apply-filters">Aplicar filtros</button>
            </form>
        </div>

        <!-- Tabla de Cursos -->
        <div class="courses-kardex">
            <div class="courses-kardex-header">
                <h2>Lista de Cursos</h2>
                <a href="index.php?page=AddCurso" id="add-course-btn" class="add-course-btn"><i class="fa fa-plus"></i>
                    Agregar Curso</a>
            </div>

            <table class="courses-table">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Alumnos Inscritos</th>
                        <th>Nivel Promedio</th>
                        <th>Ingresos Totales</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody> <?php if (!empty($cursosVentas)) : ?>
                        <?php foreach ($cursosVentas as $curso) : ?>
                            <tr class="course-row">
                                <td><a href="index.php?page=Ventas&idCurso=<?= $curso['id_curso'] ?>"><?= htmlspecialchars($curso['titulo']) ?></a></td>
                                <td><?= htmlspecialchars($curso['alumnos_inscritos']) ?></td>
                                <td><?= number_format($curso['nivel_promedio'], 2) . '%' ?></td>
                                <td>$<?= number_format($curso['ingresos_totales'], 2) ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirmarAccion()">
                                        <input type="hidden" name="idCurso" value="<?php echo $curso['id_curso']; ?>">
                                        <input type="hidden" name="nuevoEstado" value="<?php echo $curso['activo'] ? 0 : 1; ?>">
                                        <input type="hidden" name="action" value="cambiarEstadoCurso">
                                        <button type="submit">
                                            <?php echo $curso['activo'] ? 'Deshabilitar' : 'Habilitar'; ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">No se encontraron cursos con los filtros aplicados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3">Total ingresos:</td>
                        <td>
                            <?php foreach ($totalesPorPago as $pago) : ?>
                                <?= htmlspecialchars($pago['forma_pago']) ?>: $<?= number_format($pago['total_ingresos'], 2); ?><br>
                            <?php endforeach; ?>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>

            </table>

            <!-- Detalle de Alumnos -->
            <?php if (!empty($detallesCurso)) : ?>
                <div id="course-details" class="course-details">
                    <h3>Detalles del Curso: <?= htmlspecialchars($detallesCurso[0]['titulo']) ?></h3>
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Fecha de Inscripción</th>
                                <th>Nivel de Avance</th>
                                <th>Precio Pagado</th>
                                <th>Forma de Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detallesCurso as $detalle) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($detalle['alumno']) ?></td>
                                    <td><?= htmlspecialchars($detalle['fecha_inscripcion']) ?></td>
                                    <td><?= htmlspecialchars($detalle['progreso']) . '%' ?></td>
                                    <td>$<?= number_format($detalle['precio_pagado'], 2) ?></td>
                                    <td><?= htmlspecialchars($detalle['forma_pago']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Total ingresos por el curso:</td>
                                <td id="course-total">$<?= number_format($totalIngresosCurso, 2) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>


        </div>

    </div>

</div>

<script src="Views\js\JVentas.js"></script>

<?php include 'Views\Parciales\Footer.php'; ?>