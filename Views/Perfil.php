<?php include 'Views\Parciales\Head.php'; ?> 

 <link rel="stylesheet" href="Views/css/SPerfil.css">
 
<?php include 'Views\Parciales\Nav.php'; ?> 

<div class="edit-profile-container">
        <h2>Editar Perfil</h2>

        <div class="profile-pic">
            <img src="Recursos/Perfil.jpg" alt="Foto de Perfil">
        </div>

        <button id="edit-btn">Editar</button>

        <form id="profile-form" action="#" method="POST">
            <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
            <label for="rol">Rol</label>
            <select id="rol" name="rol" disabled>
                <option value="estudiante" selected>Estudiante</option>
                <option value="instructor">Instructor</option>
            </select>

            <label for="nombre">Nombre Completo</label>
            <input type="text" class="inputext" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" value="Celes" disabled>

            <label for="usuario">Usuario</label>
            <input type="text" class="inputext" id="usuario" name="usuario" placeholder="Ingresa tu nombre de usuario" value="celes_user" disabled>

            <label for="genero">Género</label>
            <select id="genero" name="genero" disabled>
                <option value="femenino">Femenino</option>
                <option value="masculino">Masculino</option>
                <option value="otro">Otro</option>
            </select>

            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="2000-01-01" disabled>

            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" name="correo" placeholder="Ingresa tu correo electrónico" value="celes@example.com" disabled>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" placeholder="Ingresa tu contraseña" value="naranja" disabled>

            <button type="submit" style="display: none;">Guardar Cambios</button>
        </form>

    </div>


<script src="Views\js\JPerfil.js"></script>

<?php include 'Views\Parciales\Footer.php'; ?> 
   