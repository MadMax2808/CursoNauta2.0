<?php include 'Views\Parciales\Head.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<?php include 'Views\Parciales\Nav.php'; ?>
<!-- Agregar -->
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
    <h2 class="text-2xl font-bold text-center text-purple-700 mb-6">Agregar Curso</h2>
    <form id="course-form" action="Ventas.html" method="POST" enctype="multipart/form-data">
        <!-- Imagen del curso -->
        <div class="mb-4">
            <label for="course-image" class="block text-sm font-medium text-gray-700">Cargar imagen del curso:</label>
            <input type="file" id="course-image" name="course_image" accept="image/*"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Título del curso -->
        <div class="mb-4">
            <label for="course-title" class="block text-sm font-medium text-gray-700">Título del curso:</label>
            <input type="text" id="course-title" name="course_title"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Descripción general del curso -->
        <div class="mb-4">
            <label for="course-description" class="block text-sm font-medium text-gray-700">Descripción general:</label>
            <textarea id="course-description" name="course_description" rows="5"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md"></textarea>
        </div>

        <!-- Cantidad de niveles -->
        <div class="mb-4">
            <label for="levels" class="block text-sm font-medium text-gray-700">Cantidad de niveles:</label>
            <input type="number" id="levels" name="levels" min="1"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md" oninput="generateLevelFields()">
        </div>

        <!-- Contenedor para los niveles, subtemas y videos -->
        <div id="level-container"></div>

        <!-- Costo del curso -->
        <div class="mb-4">
            <label for="course-price" class="block text-sm font-medium text-gray-700">Costo del curso completo:</label>
            <input type="number" id="course-price" name="course_price" step="0.01"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Costo por nivel -->
        <div class="mb-4">
            <label for="level-price" class="block text-sm font-medium text-gray-700">Costo por nivel (opcional):</label>
            <input type="number" id="level-price" name="level_price" step="0.01"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Archivos adjuntos -->
        <div class="mb-4">
            <label for="attachments" class="block text-sm font-medium text-gray-700">Adjuntar archivos de Recursos:</label>
            <input type="file" id="attachments" name="attachments[]" multiple accept=".pdf, .doc, .docx"
                class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Links externos -->
        <div class="mb-4">
            <label for="external-links" class="block text-sm font-medium text-gray-700">Links a páginas externas (opcional):</label>
            <input type="url" id="external-links" name="external_links[]" multiple
                class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        </div>

        <button type="submit" class="w-full bg-purple-700 text-white py-2 px-4 rounded-md hover:bg-purple-800">
            Guardar Curso
        </button>
    </form>
</div>

<?php include 'Views\Parciales\Footer.php'; ?>