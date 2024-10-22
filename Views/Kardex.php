<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SKardex.css">

<?php include 'Views\Parciales\Nav.php'; ?>

<!-- Cursos y Filtros -->
<div class="container">
    <div class="kardex-section">
        <!-- Filtros -->
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

        <!-- Cursos Kardex -->
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
                    <tr>
                        <td>Curso de Diseño Web</td>
                        <td>15/01/2024</td>
                        <td>10/09/2024</td>
                        <td>75%</td>
                        <td>N/A</td>
                        <td>Desarrollo Web</td>
                        <td class="status incomplete">Incompleto</td>
                    </tr>
                    <tr>
                        <td>Curso de Programación en Python</td>
                        <td>05/02/2024</td>
                        <td>15/09/2024</td>
                        <td>100%</td>
                        <td>15/09/2024</td>
                        <td>Programación</td>
                        <td class="status completed">Completo</td>
                    </tr>
                    <tr>
                        <td>Curso de Marketing Digital</td>
                        <td>10/03/2024</td>
                        <td>12/09/2024</td>
                        <td>50%</td>
                        <td>N/A</td>
                        <td>Marketing</td>
                        <td class="status incomplete">Incompleto</td>
                    </tr>
                    <tr>
                        <td>Curso de Fotografía Profesional</td>
                        <td>20/04/2024</td>
                        <td>14/09/2024</td>
                        <td>90%</td>
                        <td>N/A</td>
                        <td>Diseño</td>
                        <td class="status incomplete">Incompleto</td>
                    </tr>
                    <tr>
                        <td>Curso de Desarrollo en JavaScript</td>
                        <td>15/05/2024</td>
                        <td>16/09/2024</td>
                        <td>100%</td>
                        <td>16/09/2024</td>
                        <td>Desarrollo Web</td>
                        <td class="status completed">Completo</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include 'Views\Parciales\Footer.php'; ?>