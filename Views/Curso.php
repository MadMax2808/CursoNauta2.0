<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SCurso.css">

<?php include 'Views\Parciales\Nav.php'; ?>

<div class="course-container">

<div class="course-header">
    <h1 class="course-title">Introducción al Diseño Web</h1>
    <p class="course-category"> Desarrollo Web</p>
    <p class="course-category"><strong>Creador:</strong> Juan Pérez</p>
</div>

<div class="course-description">
    <p>Este curso ofrece una introducción completa al diseño web, cubriendo desde los conceptos básicos de HTML
        y CSS hasta las técnicas fundamentales de JavaScript. Ideal para principiantes que desean adquirir
        habilidades prácticas en desarrollo web.</p>
</div>

<div class="course-content">
    <div class="video-and-topics">

        <div class="video-section">
            <video id="course-video" src="Recursos/Over.mp4" controls></video>

            <h4>Tu progreso: 50%</h4>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 50%;"></div>
            </div>

        </div>

        <div class="topics-section">
            <div class="topic-title">
                <i class="fas fa-book"></i> <!-- Cambia el ícono según tus preferencias -->
                <h2>9 Lecciones</h2>
            </div>
            <ul class="topics-list">
                <li>
                    <button class="topic-btn">HTML Básico <span class="arrow">▶</span></button>
                    <ul class="subtopics-list">
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic1"><label
                                for="subtopic1"><a href="Recursos/Star.mp4"
                                    class="subtopic-link">Introducción</a></label></li>
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic2"><label
                                for="subtopic2"><a href="Recursos/Star.mp4" class="subtopic-link">Elementos y
                                    Etiquetas</a></label></li>
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic3"><label
                                for="subtopic3"><a href="Recursos/Star.mp4"
                                    class="subtopic-link">Formularios</a></label></li>
                    </ul>
                </li>
                <li>
                    <button class="topic-btn">CSS Básico <span class="arrow">▶</span></button>
                    <ul class="subtopics-list">
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic4"><label
                                for="subtopic4"><a href="Recursos/Over2.mp4" class="subtopic-link">Estilos en
                                    Línea</a></label></li>
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic5"><label
                                for="subtopic5"><a href="Recursos/Over2.mp4"
                                    class="subtopic-link">Selectors</a></label></li>
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic6"><label
                                for="subtopic6"><a href="Recursos/Over2.mp4" class="subtopic-link">Diseño de
                                    Página</a></label></li>
                    </ul>
                </li>
                <li>
                    <button class="topic-btn">JavaScript <span class="arrow">▶</span></button>
                    <ul class="subtopics-list">
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic7"><label
                                for="subtopic7"><a href="Recursos/Over2.mp4" class="subtopic-link">Variables y
                                    Tipos de Datos</a></label></li>
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic8"><label
                                for="subtopic8"><a href="Recursos/Over2.mp4"
                                    class="subtopic-link">Funciones</a></label></li>
                        <li><input type="checkbox" class="subtopic-checkbox" id="subtopic9"><label
                                for="subtopic9"><a href="Recursos/Over2.mp4"
                                    class="subtopic-link">Eventos</a></label></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>

    <div class="course-resources">
        <div class="resource-header">

            <span>Recursos</span>

            <span class="toggle-icon">▶</span>
        </div>
        <div class="resource-content">
            <ul>
                <li>
                    <!-- <img src="Recursos/Star.png" alt="Recurso 1" class="resource-image"> -->
                    <a href="Recursos/CFnaf.pdf" download><i class="file-icon">📄</i> Descargar PDF 1</a>
                </li>
                <li>
                    <!-- <img src="Recursos/Star.png" alt="Recurso 2" class="resource-image"> -->
                    <a href="Recursos/" download><i class="file-icon">📄</i> Descargar PDF 2</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="feedback-section">
        <h2>Valoraciones</h2>
        <div class="ratings">
            <span class="rating">⭐⭐⭐⭐☆</span> <!-- 4 estrellas de 5 -->
            <span>(20 valoraciones)</span>
        </div>


        <div class="comments">
            <h2>Comentarios</h2>

            <div class="comment">
                <div class="user-info">
                    <img src="Recursos/Icon.png" alt="Foto del Usuario" class="comment-user-img">
                    <div>
                        <p class="comment-username"> MikeWas</p>
                        <p class="comment-date">12/09/2024, 14:30</p>
                    </div>
                </div>
                <p class="comment-text">Buen Curso, tiene lo necesario para empezar a entrar al mundo del diseño
                    web, aunque me gustaria que fuera mas largo</p>
                <button class="delete-btn">Eliminar</button>
            </div>

            <div class="comment">
                <div class="user-info">
                    <img src="Recursos/Icon.png" alt="Foto del Usuario" class="comment-user-img">
                    <div>
                        <p class="comment-username"> MikeWas'Nt</p>
                        <p class="comment-date">05/07/2024, 17:30</p>
                    </div>
                </div>
                <p class="comment-text">Que feo curso</p>
                <button class="delete-btn">Eliminar</button>
            </div>


        </div>

    </div>
</div>

<div class="course-purchase">
    <h2>Adquiere este curso</h2>
    <p class="course-price"><strong>$49.99</strong></p>
    <a href="index.php?page=Pago" class="purchase-btn">Comprar Curso</a>
</div>
</div>

<script src="Views\js\JCurso.js"> </script>

<?php include 'Views\Parciales\Footer.php'; ?> 