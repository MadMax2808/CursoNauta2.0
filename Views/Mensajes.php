<?php include 'Views\Parciales\Head.php'; ?>

<link rel="stylesheet" href="Views/css/SMensajes.css">

<?php include 'Views\Parciales\Nav.php'; ?>


<div class="container">
    <aside class="sidebar">
        <h2>Instructores</h2>
        <ul>
            <li>
                <img src="Views/Recursos/Perfil2.jpg" alt="Instructor 1" class="instructor-img">
                <span>Ana Gómez</span>
            </li>
            <li>
                <img src="Views/Recursos/Perfil3.jpg" alt="Instructor 2" class="instructor-img">
                <span>Lizbeth </span>
            </li>

        </ul>
    </aside>
    <main class="main-content">
        <section class="messages">
            <h2>Mensajes Privados</h2>

            <div class="message-container">

                <div class="message">
                    <img src="Views/Recursos/Perfil.jpg" alt="Usuario 1" class="user-img">
                    <div class="message-content">
                        <div class="message-header">
                            <span class="user-name2">Celes</span>
                            <span class="message-time">2024-09-15 14:30</span>
                        </div>
                        <p class="message-text">Hola, ¿podrías ayudarme con la tarea 2 del curso?</p>
                    </div>
                </div>

                <div class="message instructor">
                    <img src="Views/Recursos/Perfil2.jpg" alt="Instructor" class="user-img">
                    <div class="message-content">
                        <div class="message-header">
                            <span class="user-name">Instructora Ana</span>
                            <span class="message-time">2024-09-15 15:00</span>
                        </div>
                        <p class="message-text">¡Claro!</p>
                    </div>
                </div>

            </div>

            <div class="message-form">
                <textarea placeholder="Escribe tu mensaje..."></textarea>
                <button class="btn">Enviar</button>
            </div>


        </section>
    </main>
</div>

<?php include 'Views\Parciales\Footer.php'; ?>