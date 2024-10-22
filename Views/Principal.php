<?php include 'Views\Parciales\Head.php'; ?> 

 <link rel="stylesheet" href="Views/css/SPrincipal.css">
 
<?php include 'Views\Parciales\Nav.php'; ?> 

    <!-- Presentación -->
<section id="inicio" class="hero">
        <h2>Explora y Mejora tus Habilidades Creativas</h2>
        <p>Únete a una comunidad que aprende y comparte conocimientos creativos.</p>
        <a href="index.php?page=All" class="btn">Explorar Cursos</a>
</section>

  <!-- Cursos -->
<section class="courses-carousel">
        <h2>Cursos Destacados</h2>

        <!-- Flecha izquierda -->
        <button class="carousel-arrow left-arrow">&#9664;</button>

        <!-- Contenedor de los cursos -->
        <div class="course-grid">
            <a href="index.php?page=Curso">
            <div class="course-card">
                <img src="Views\Recursos\C1.jpg" Imagen del Curso" class="course-img">
             
                <h3 >Curso de Diseño Gráfico</h3>
            
                <span class="course-category">Diseño</span>
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>Niveles: 3</p>
                <p>Costo: $40</p>
                <p>Aprende los fundamentos del diseño gráfico para crear proyectos impresionantes.</p>
            </div>
           </a>  

            <div class="course-card">
                <img src="Views\Recursos\C2.jpg" alt="Imagen del Curso" class="course-img">
                <h3>Curso de Ilustración Digital</h3>
                <span class="course-category">Ilustración</span>
                <div class="stars">⭐⭐⭐⭐☆</div>
                <p>Niveles: 5</p>
                <p>Costo: $50</p>
                <p>Domina las técnicas de ilustración digital usando herramientas avanzadas.</p>
            </div>


            <div class="course-card">
                <img src="Views\Recursos\C3.jpg" alt="Imagen del Curso" class="course-img">
                <h3>Curso de Animación 3D</h3>
                <span class="course-category">Animación</span>
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>Niveles: 7</p>
                <p>Costo: $80</p>
                <p>Explora la animación en 3D y lleva tus ideas al siguiente nivel con software profesional.</p>
            </div>


            <div class="course-card">
                <img src="Views\Recursos\C4.png" alt="Imagen del Curso" class="course-img">
                <h3>Curso de Fotografía</h3>
                <span class="course-category">Fotografía</span>
                <div class="stars">⭐⭐⭐⭐☆</div>
                <p>Niveles: 4</p>
                <p>Costo: $35</p>
                <p>Aprende los fundamentos de la fotografía para capturar imágenes impactantes.</p>
            </div>


            <div class="course-card">
                <img src="Views\Recursos\C5.jpeg" alt="Imagen del Curso" class="course-img">
                <h3>Curso de Desarrollo Web</h3>
                <span class="course-category">Programación</span>
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>Niveles: 6</p>
                <p>Costo: $60</p>
                <p>Domina el desarrollo web con HTML, CSS, JavaScript y más herramientas modernas.</p>
            </div>


            <div class="course-card">
                <img src="Views\Recursos\C6.jpg" alt="Imagen del Curso" class="course-img">
                <h3>Curso de Marketing Digital</h3>
                <span class="course-category">Marketing</span>
                <div class="stars">⭐⭐⭐⭐☆</div>
                <p>Niveles: 5</p>
                <p>Costo: $45</p>
                <p>Descubre cómo crear y ejecutar campañas de marketing digital exitosas.</p>
            </div>
        </div>

        <!-- Flecha derecha -->
        <button class="carousel-arrow right-arrow">&#9654;</button>
</section>

<?php include 'Views\Parciales\Footer.php'; ?> 