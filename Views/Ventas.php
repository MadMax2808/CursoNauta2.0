<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SVentas.css">

<?php include 'Views\Parciales\Nav.php';


require_once 'Controllers/VentasController.php';

$database = new Database();
$db = $database->getConnection();

$ventasController = new VentasController($db);
$data = $ventasController->obtenerVentas();
$cursosVentas = $data['cursosVentas'];
$totalesPorPago = $data['totalesPorPago'];

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

<!-- Lista Ventas -->
<div class="container">

    <div class="kardex-section">
        <!-- Filtros -->
        <div class="filters">
            <h3>Filtrar cursos</h3>

            <div class="filter-date">
                <label for="start-date">Fecha de creación (inicio)</label>
                <input type="date" id="start-date">
                <label for="end-date">Fecha de creación (fin)</label>
                <input type="date" id="end-date">
            </div>

            <div class="filter-category">
                <label for="category">Categoría</label>
                <select id="category">
                    <option value="all">Todas las categorías</option>
                    <option value="web">Desarrollo Web</option>
                    <option value="programming">Programación</option>
                    <option value="design">Diseño</option>
                </select>
            </div>

            <div class="filter-status">
                <label for="completed">Estado del Curso</label>
                <select id="completed">
                    <option value="all">Todos</option>
                    <option value="incomplete">Solo cursos activos</option>
                </select>
            </div>

            <button class="apply-filters">Aplicar filtros</button>
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
                <tbody>
                    <?php foreach ($cursosVentas as $curso) : ?>
                        <tr class="course-row">
                            <td><a href="index.php?page=Ventas&idCurso=<?= $curso['id_curso'] ?>"><?= htmlspecialchars($curso['titulo']) ?></a></td>
                            <td><?= htmlspecialchars($curso['alumnos_inscritos']) ?></td>
                            <td><?= number_format($curso['nivel_promedio'], 2) . '%' ?></td>
                            <td>$<?= number_format($curso['ingresos_totales'], 2) ?></td>
                            <td><button id="course-des">Deshabilitar</button></td>
                        </tr>
                    <?php endforeach; ?>
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
                    <h3>Detalles del Curso</h3>
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