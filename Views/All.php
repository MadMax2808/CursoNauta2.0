<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SAll.css">

<?php include 'Views\Parciales\Nav.php'; ?>

<section class="courses-section">

<!-- Filtros -->
<div class="filters">
    <h3>Filtrar Por:</h3>

    <div class="filter-category">
        <label for="category">Categoría:</label>
        <select id="category">
            <option value="">Todas las categorías</option>
            <option value="Diseño">Diseño</option>
            <option value="Ilustración">Ilustración</option>
            <option value="Animación">Animación</option>
            <option value="Fotografía">Fotografía</option>
            <option value="Programación">Programación</option>
            <option value="Marketing">Marketing</option>
        </select>
    </div>

    <div class="filter-user">
        <label for="user">Instructor:</label>
        <select id="user">
            <option value="">Todos los Instructores</option>
            <option value="usuario1">Diego Ramirez</option>
            <option value="usuario2">Sofia Hernandez</option>
            <option value="usuario3">Erika Lara</option>
        </select>
    </div>

    <div class="filter-date">
        <label for="date-range">Rango de fechas:</label>
        <input type="date" id="start-date" placeholder="Desde">
        <input type="date" id="end-date" placeholder="Hasta">
    </div>

    <button class="apply-filters">Aplicar Filtros</button>
</div>

<!-- Cursos -->
<section class="courses-carousel">
    <h2>Cursos</h2>

    <!-- Contenedor de los cursos -->
    <div class="course-grid">
        <div class="course-card">
            <img src="Recursos/C1.jpg" alt="Imagen del Curso" class="course-img">
            <h3>Curso de Diseño Gráfico</h3>
            <span class="course-category">Diseño</span>
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <strong>Instructor: Diego Ramirez</strong>
            <p>Niveles: 3</p>
            <p>Costo: $40</p>
            <p>Aprende los fundamentos del diseño gráfico para crear proyectos impresionantes.</p>
        </div>

        <div class="course-card">
            <img src="Recursos/C2.jpg" alt="Imagen del Curso" class="course-img">
            <h3>Curso de Ilustración Digital</h3>
            <span class="course-category">Ilustración</span>
            <div class="stars">⭐⭐⭐⭐☆</div>
            <strong>Instructor: Sofia Hernandez</strong>
            <p>Niveles: 5</p>
            <p>Costo: $50</p>
            <p>Domina las técnicas de ilustración digital usando herramientas avanzadas.</p>
        </div>

        <div class="course-card">
            <img src="Recursos/C3.jpg" alt="Imagen del Curso" class="course-img">
            <h3>Curso de Animación 3D</h3>
            <span class="course-category">Animación</span>
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <strong>Instructor: Erika Lara</strong>
            <p>Niveles: 7</p>
            <p>Costo: $80</p>
            <p>Explora la animación en 3D y lleva tus ideas al siguiente nivel con software profesional.</p>
        </div>

        <div class="course-card">
            <img src="Recursos/C4.png" alt="Imagen del Curso" class="course-img">
            <h3>Curso de Fotografía</h3>
            <span class="course-category">Fotografía</span>
            <div class="stars">⭐⭐⭐⭐☆</div>
            <strong>Instructor: Fito Guerrero</strong>
            <p>Niveles: 4</p>
            <p>Costo: $35</p>
            <p>Aprende los fundamentos de la fotografía para capturar imágenes impactantes.</p>
        </div>

        <div class="course-card">
            <img src="Recursos/C5.jpeg" alt="Imagen del Curso" class="course-img">
            <h3>Curso de Desarrollo Web</h3>
            <span class="course-category">Programación</span>
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <strong>Instructor: Alexa Gutierrez</strong>
            <p>Niveles: 6</p>
            <p>Costo: $60</p>
            <p>Domina el desarrollo web con HTML, CSS, JavaScript y más herramientas modernas.</p>
        </div>

        <div class="course-card">
            <img src="Recursos/C6.jpg" alt="Imagen del Curso" class="course-img">
            <h3>Curso de Marketing Digital</h3>
            <span class="course-category">Marketing</span>
            <div class="stars">⭐⭐⭐⭐☆</div>
            <strong>Instructor: Martin Aguilar</strong>
            <p>Niveles: 5</p>
            <p>Costo: $45</p>
            <p>Descubre cómo crear y ejecutar campañas de marketing digital exitosas.</p>
        </div>
    </div>


</section>

</section>

<?php include 'Views\Parciales\Footer.php'; ?>