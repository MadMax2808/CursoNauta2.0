<?php

include_once 'Models\Database.php';

$database = new Database();
$db = $database->getConnection();

include 'Models/Router.php';

$router = new Router('routes.php');

$router->handleRequest();
