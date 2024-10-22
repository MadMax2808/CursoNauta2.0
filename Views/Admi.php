<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SAdmi.css">

<?php include 'Views\Parciales\Nav.php'; ?>

<div class="admin-container">
    <div class="main-content">
        <div class="left-pane">
            <button class="active" onclick="showContent('usuarios')">Usuarios</button>
            <button onclick="showContent('cursos')">Cursos</button>
            <button onclick="showContent('categorias')">Categorías</button>
            <button onclick="showContent('reportes')">Reportes</button>
        </div>

        <!-- Contenido Principal -->
        <div class="right-pane">
            <!-- Contenido para Lista de Usuarios -->
            <div class="section" id="usuarios">
                <h1>Lista de Usuarios</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Fecha de Ingreso</th>
                            <th>Rol</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Juan Pérez</td>
                            <td>01/01/2024</td>
                            <td>Instructor</td>
                            <td>
                                <button>Habilitar</button>
                                <button>Deshabilitar</button>
                            </td>
                        </tr>
                        <!-- Más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <!-- Contenido para Lista de Cursos -->
            <div class="section" id="cursos" style="display: none;">
                <h1>Lista de Cursos</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Creador</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Descripción del Curso 1</td>
                            <td>Activo</td>
                            <td>Laura Gómez</td>
                            <td>
                                <button>Habilitar</button>
                                <button>Deshabilitar</button>
                            </td>
                        </tr>
                        <!-- Más filas según sea necesario -->
                    </tbody>
                </table>
            </div>

            <!-- Contenido para Lista de Categorías -->
            <div class="section" id="categorias" style="display: none;">
                <h1>Lista de Categorías</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Seguridad y Medio Ambiente</td>
                            <td>Aquí se estudian aspectos relacionados con la seguridad laboral, la prevención de riesgos y la protección del medio ambiente.</td>
                            <td>
                                <button>Editar</button>
                                <button>Borrar</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <button type="button" onclick="toggleCategoryForm(true)">Agregar Nueva Categoría</button>

                <div id="add-category-form" style="display: none; margin-top: 20px;">
                    <h2>Agregar Nueva Categoría</h2>
                    <form id="category-form">
                        <label for="category-title">Título:</label>
                        <input type="text" id="category-title" name="category-title">
                        <label for="category-description">Descripción:</label>
                        <textarea id="category-description" name="category-description" rows="4"></textarea>
                        <div class="button-group">
                            <button type="submit">Guardar Categoría</button>
                            <button type="button" onclick="toggleCategoryForm(false)">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sección de Reportes -->
            <div class="section" id="reportes" style="display: none;">
                <h1>Obtener Reportes</h1>
                <!-- <form> -->
                <label for="user-type">Tipo de Usuario:</label>
                <select id="user-type" name="user-type">
                    <option value="instructor">Instructor</option>
                    <option value="estudiante">Estudiante</option>
                </select>
                <button>Generar Reporte</button>
                <!-- </form> -->

                <div class="course-details">

                    <h2>Reporte de Instructores</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Fecha de Ingreso</th>
                                <th>Cantidad de Cursos Ofrecidos</th>
                                <th>Total de Ganancias</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>instructor1</td>
                                <td>Laura Gómez</td>
                                <td>01/01/2023</td>
                                <td>5</td>
                                <td>$5000</td>
                            </tr>

                        </tbody>
                    </table>

                    <h2>Reporte de Estudiantes</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Fecha de Ingreso</th>
                                <th>Cantidad de Cursos Inscritos</th>
                                <th>% de Cursos Terminados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>estudiante1</td>
                                <td>Carmen Díaz</td>
                                <td>15/02/2023</td>
                                <td>3</td>
                                <td>75%</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="Views\js\JAdmi.js"> </script>

<?php include 'Views\Parciales\Footer.php'; ?>