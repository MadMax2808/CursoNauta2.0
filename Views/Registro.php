<?php include 'Views\Parciales\Head.php'; ?>

<div class="register-container">
        <h2>Registro</h2>
        <form action="Login.html" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="photo">Cargar foto:</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>

            <div class="form-group">
                <label for="role">Rol:</label>
                <select id="role" name="role">
                    <option value="instructor">Instructor</option>
                    <option value="estudiante">Estudiante</option>
                </select>
            </div>

            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username">
            </div>

            <div class="form-group">
                <label for="full-name">Nombre Completo:</label>
                <input type="text" id="full-name" name="full_name">
            </div>

            <div class="form-group">
                <label for="gender">Género:</label>
                <select id="gender" name="gender">
                    <option value="male">Masculino</option>
                    <option value="female">Femenino</option>
                    <option value="other">Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="birthdate">Fecha de Nacimiento:</label>
                <input type="date" id="birthdate" name="birthdate">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" >
            </div>

            <button type="submit" class="btn-register">Registrar</button>

            <!-- Enlace de Iniciar Sesión -->
            <div class="login-link">
                <p>¿Ya tienes cuenta? <a href="Login.html">Iniciar sesión</a></p>
            </div>

        </form>
</div>

<script src="Views\js\JRegistro.js"> </script>

<?php include 'Views\Parciales\Footer.php'; ?> 