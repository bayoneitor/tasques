<?php
require APP . '/src/render.php';
if (isset($_SESSION["uname"])) {
    header('Location: ?url=home');
} else {
    echo render('register', ['title' => "Register", 'controller' => "$controller"]);
}
