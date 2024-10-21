<?php

include_once 'Models\Database.php';

// Obtener la conexión
$database = new Database();
$db = $database->getConnection();

// Incluir la clase Router
include 'Models/Router.php';

// Crear una instancia del Router y cargar las rutas desde routes.php
$router = new Router('routes.php');

// Manejar la solicitud actual
$router->handleRequest();
