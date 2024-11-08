<?php
require_once 'Controllers/InscripcionController.php';
include 'Views/Parciales/Head.php';
include 'Views/Parciales/Nav.php';

$inscripcionController = new InscripcionController();
$cursos = $inscripcionController->mostrarCursosInscritos(); // Llama al método para obtener los cursos
?>

<link rel="stylesheet" href="Views/css/SKardex.css">

<div class="container">
    <div class="kardex-section">
        <div class="filters">
            <h3>Filtrar cursos</h3>

            <!-- Rango de Fechas -->
            <div class="filter-date">
                <label for="start-date">Fecha de inscripción (inicio)</label>
                <input type="date" id="start-date">
                <label for="end-date">Fecha de inscripción (fin)</label>
                <input type="date" id="end-date">
            </div>

            <!-- Categoría -->
            <div class="filter-category">
                <label for="category">Categoría</label>
                <select id="category">
                    <option value="all">Todas las categorías</option>
                    <option value="web">Desarrollo Web</option>
                    <option value="programming">Programación</option>
                    <option value="design">Diseño</option>
                </select>
            </div>

            <!-- Cursos Terminados -->
            <div class="filter-status">
                <label for="completed">Estado del Curso</label>
                <select id="completed">
                    <option value="all">Todos</option>
                    <option value="completed">Solo cursos terminados</option>
                    <option value="incomplete">Solo cursos activos</option>
                </select>
            </div>

            <!-- Aplicar Filtros -->
            <button class="apply-filters">Aplicar filtros</button>
        </div>


        <div class="courses-kardex">
            <h2>Kardex</h2>
            <table class="courses-table">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Fecha de Inscripción</th>
                        <th>Último Acceso</th>
                        <th>Progreso</th>
                        <th>Fecha de Terminación</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($curso['curso_titulo']); ?></td>
                            <td><?php echo htmlspecialchars($curso['fecha_inscripcion']); ?></td>
                            <td><?php echo htmlspecialchars($curso['fecha_ultimo_acceso']); ?></td>
                            <td><?php echo htmlspecialchars($curso['progreso']) . '%'; ?></td>
                            <td><?php echo htmlspecialchars($curso['fecha_terminacion'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($curso['categoria']); ?></td>
                            <td class="status <?php echo $curso['estado'] === 'completado' ? 'completed' : 'incomplete'; ?>">
                                <?php echo htmlspecialchars($curso['estado']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'Views/Parciales/Footer.php'; ?>
w