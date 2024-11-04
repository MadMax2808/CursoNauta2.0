<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SVentas.css">

<?php include 'Views\Parciales\Nav.php'; ?>

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
                    <tr class="course-row" data-course="Curso de Desarrollo Web">
                        <td>Curso de Desarrollo Web</td>
                        <td>20</td>
                        <td>85%</td>
                        <td>$25,000.00</td>
                        <td>
                            <button id="course-des">Deshabilitar</button>
                        </td>
                    </tr>
                    <tr class="course-row" data-course="Curso de Programación en Python">
                        <td>Curso de Programación en Python</td>
                        <td>15</td>
                        <td>90%</td>
                        <td>$18,000.00</td>
                        <td>
                            <button>Deshabilitar</button>
                        </td>
                    </tr>
                </tbody>
                <!-- Total ingresos por todos los cursos -->
                <tfoot>
                    <tr>
                        <td colspan="3">Total ingresos:</td>
                        <td>Tarjeta: $30,000.00, PayPal: $13,000.00</td>
                        <td> </td>
                    </tr>
                </tfoot>
            </table>

            <!-- Detalle de Alumnos Oculto -->
            <div id="course-details" class="course-details" style="display: none;">
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
                    <tbody id="students-body">
                        <!-- Los detalles de los alumnos se actualizarán dinámicamente -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Total ingresos por el curso:</td>
                            <td id="course-total">$0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>

</div>

<script src="Views\js\JVentas.js"></script>

<?php include 'Views\Parciales\Footer.php'; ?>