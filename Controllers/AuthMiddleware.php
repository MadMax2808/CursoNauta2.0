<?php
class AuthMiddleware
{
    public static function checkAuthentication($requiredRole = null)
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si la sesión está iniciada
        if (!isset($_SESSION['user_id'])) {
            echo "<script>
                    alert('Debe iniciar sesión para acceder a esta página.');
                    window.location.href = 'index.php?page=Login';
                  </script>";
            exit();
        }

        // Verificar el rol del usuario, si se requiere un rol específico
        if ($requiredRole && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $requiredRole)) {
            echo "<script>
            alert('No tienes acceso a esta página.');
            window.location.href = 'index.php?page=Principal';
          </script>";
            exit();
        }
    }
}
