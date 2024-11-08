<?php
// init.php

require_once 'Controllers/AuthMiddleware.php';

// Cargar las rutas desde el archivo de configuración
$routes = require 'routes.php';

// Definir las reglas de autenticación para cada ruta
// La clave es el nombre de la página, y el valor es el rol requerido (1 = admin, 2 = instructor, 3 = estudiante)
// Usa `null` si solo necesita autenticación sin un rol específico
$routesWithAuthentication = [
    'Perfil' => 0,          // Requiere autenticación pero no un rol específico
    'Ventas' => 2,             // Solo para instructores
    'Admi' => 1,               // Solo para administradores
    'AddCurso' => 1,           // Solo para administradores
    'Kardex' => 3,             // Solo para estudiantes
    
];

// Obtener la página solicitada desde la URL (por ejemplo, `index.php?page=Perfil`)
$page = $_GET['page'] ?? 'Principal';

// Verificar si la página solicitada requiere autenticación o un rol específico
if (isset($routesWithAuthentication[$page])) {
    $requiredRole = $routesWithAuthentication[$page];
    AuthMiddleware::checkAuthentication($requiredRole);
}
