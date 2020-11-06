<?php
// Iniciar session y mantener session
// session_start();
// Eliminar elementos de la variable session
session_unset();
// Destruye la variable de session y la cookie
session_destroy();
// Redirige a index.php

//Eliminar cookie
setcookie("uname", $user, time() - 1, "/M7/exercici1/SESS_COOK/");
setcookie("password", $pwd, time() - 1, "/M7/exercici1/SESS_COOK/");
setcookie("lastTime", $pwd, time() - 1, "/M7/exercici1/SESS_COOK/");

header('Location: ?url=home');
