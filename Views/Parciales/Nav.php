<header>
    <div class="logo">
        <img src="Views/Recursos/Icon2.png" alt="Logo de CursoNauta" class="logo-img">
        <h1>CursoNauta</h1>
    </div>

    <!-- Barra -->
    <div class="search-bar">
        <input type="text" placeholder="Buscar cursos...">
        <button class="search-button" id="search-btn">
            <span class="material-icons">search</span>
        </button>
    </div>

    <nav>
        <ul>
            <li><a href="Principal.html">Inicio</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-btn">Categorías</a>
                <ul class="dropdown-content">
                    <li><a href="All.html">Diseño</a></li>
                    <li><a href="All.html">Ilustración</a></li>
                    <li><a href="All.html">Animación</a></li>
                    <li><a href="All.html">Fotografía</a></li>
                </ul>
            </li>
            <li><a href="All.html">Cursos</a></li>

        </ul>
    </nav>

    <div class="user-profile" id="user-profile">
        <?php
        session_start(); // Asegúrate de tener esto al principio del archivo para iniciar la sesión.
        ?>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Si no ha iniciado sesión, muestra "Iniciar Sesión" -->
            <a href="index.php?page=Login" class="btn-login">Iniciar Sesión</a>
        <?php else: ?>

            <!-- Si ha iniciado sesión, muestra los datos del usuario y las opciones según su rol -->
            <a href="" class="profile-toggle">
                <img src="Views/Recursos/Perfil.jpg" alt="Usuario" class="user-img">
            </a>
            <div class="user-info profile-toggle">
                <p class="user-name"><?php echo $_SESSION['user_name']; ?></p>
                <p class="user-role"><?php echo ucfirst($_SESSION['user_role']); ?></p>
            </div>

            <!-- Menú desplegable según el rol del usuario -->
            <ul class="dropdown-menu">
                <li><a href="index.php?page=perfil">Mi perfil</a></li>

                <?php if ($_SESSION['user_role'] == 'estudiante'): ?>
                    <li><a href="index.php?page=mensajes">Mis Mensajes</a></li>
                    <li><a href="index.php?page=kardex">Kardex</a></li>

                <?php elseif ($_SESSION['user_role'] == 'vendedor'): ?>
                    <li><a href="index.php?page=ventas">Mis Ventas</a></li>
                <?php elseif ($_SESSION['user_role'] == 'administrador'): ?>

                    <li><a href="index.php?page=admi">Administración</a></li>
                <?php endif; ?>

                <li><a href="index.php?page=logout">Cerrar Sesión</a></li>
            </ul>
        <?php endif; ?>
    </div>
</header>

<script src="Views\js\Nav.js"></script>