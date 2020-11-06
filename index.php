<?php
ini_set('display_errors', 'On');
//configuracion entrono
define('APP', __DIR__);
require APP . '/src/route.php';
//Variable por si es web o local
$web = "/";
//sessions && cookie
session_start();

if (isset($_SESSION["uname"]) || isset($_SESSION["email"])) {
    $uname = $_SESSION["uname"];
    $email = $_SESSION["email"];
    $id = $_SESSION["id"];
}

//sistema de enrutamiento
$controller = getRoute();

//rederigiar a ruta adecuada
require APP . '/controllers/' . $controller . '.php';
