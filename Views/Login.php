<?php include 'Views\Parciales\Head.php'; ?>
<link rel="stylesheet" href="Views\css\SLoRe.css">

<div class="register-container">
        <h2>Iniciar Sesión</h2>
        <form action="index.php?page=authenticate" method="POST">
            <div class="form-group">
                <label for="email">Correo:</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password">
            </div>

        <button type="submit" class="btn-register">Iniciar Sesión</button>
            <!-- Enlace para registro -->
            <div class="login-link">
                <p>¿No tienes cuenta? <a href="Registro.php">Regístrate aquí</a></p>
            </div>
        </form>
    </div>


</body>