<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SAddCurso.css">

<?php include 'Views\Parciales\Nav.php'; ?>
<!-- Agregar -->
<div class="add-courses-page">
    <div class="container">
        <h2>Agregar Curso</h2>
        <form id="course-form" action="Ventas.html" method="POST" enctype="multipart/form-data">
            
            <!-- Contenedor de Información General -->
            <div class="general-info">
                <div class="row">
                    <div class="field">
                        <label for="course-image">Cargar imagen del curso:</label>
                        <input type="file" id="course-image" name="course_image" accept="image/*">
                    </div>
                    <div class="field">
                        <label for="course-title">Título del curso:</label>
                        <input type="text" id="course-title" name="course_title">
                    </div>
                </div>

                <div class="row">
                    <div class="field">
                        <label for="levels">Cantidad de niveles:</label>
                        <input type="number" id="levels" name="levels" min="1" oninput="generateLevelFields()">
                    </div>
                    <div class="field">
                        <label for="course-price">Costo del curso completo:</label>
                        <input type="number" id="course-price" name="course_price" step="0.01">
                    </div>
                    <div class="field">
                        <label for="level-price">Costo por nivel (opcional):</label>
                        <input type="number" id="level-price" name="level_price" step="0.01">
                    </div>
                </div>

                <label for="course-description">Descripción general:</label>
                <textarea id="course-description" name="course_description" rows="3"></textarea>
            </div>

            <!-- Contenedor de Niveles -->
            <div id="level-container" class="level-container"></div>

            <!-- Botón de envío -->
            <button type="submit">Guardar Curso</button>
        </form>
    </div>
</div>

<script src="Views\js\JAddCurso.js"> </script>

<?php include 'Views\Parciales\Footer.php'; ?>