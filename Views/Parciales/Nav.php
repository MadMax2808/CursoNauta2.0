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

        <div class="user-profile" id="user-profile" style="display: none;" >
            <a href="Perfil.html" class="profile-toggle">
                <img src="Recursos/Perfil.jpg" alt="Usuario" class="user-img">
            </a>
            <div class="user-info profile-toggle">
                <p class="user-name">Celes</p>
                <p class="user-role">Estudiante</p>
            </div>

            <!-- Menú desplegable -->
            <ul class="dropdown-menu">
                <li><a href="Perfil.html">Mi perfil</a></li>
                <li><a href="Mensajes.html">Mis mensajes</a></li>
                <li><a href="Kardex.html">Kardex</a></li>
                <li><a href="Ventas.html">Mis Ventas</a></li>
                <li><a href="Admi.html">Admi</a></li>
                <li><a href="Login.html">Cerrar Sesión</a></li>
            </ul>
        </div>
</header>
