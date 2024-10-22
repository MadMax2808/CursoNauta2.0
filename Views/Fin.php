<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SFin.css">


<div class="completion-section">
    <h2>¡Felicidades por completar el curso!</h2>
    <p>Has completado satisfactoriamente el curso <strong>Programación Web</strong>. Aquí tienes tu diploma:</p>

    <!-- Diploma -->
    <div class="diploma-container">
        <div class="diploma-header">
            <h1>Diploma de Reconocimiento</h1>
        </div>
        <div class="diploma-body">
            <p>Este diploma se otorga a:</p>
            <h2>Nombre del Estudiante</h2>
            <p>En reconocimiento a su excelente desempeño y dedicación en el curso de:</p>
            <h3>Nombre del Curso</h3>
        </div>
        <div class="diploma-footer">
            <div class="signature">
                <p>Firma del Instructor</p>
                <hr>
                <p>Instructor</p>
            </div>
            <div class="date">
                <p>Fecha de Emisión</p>
                <hr>
                <p>dd/mm/aaaa</p>
            </div>
        </div>
    </div>

    <!-- Botón para descargar diploma -->
    <a href="Diploma.html" download="Diploma_NombreEstudiante.png" class="download-button">Descargar Diploma</a>

    <!-- Sección para valorar el curso -->
    <div class="rating-section">
        <h3>Valora el curso</h3>
        <div class="stars">
            <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
        </div>
    </div>

    <!-- Sección para comentarios -->
    <div class="comments-section">
        <h3>Deja un comentario</h3>
        <textarea placeholder="Escribe tu comentario aquí..."></textarea>
        <button class="submit-comment">Enviar comentario</button>
    </div>
</div>
