
<?php
require APP . '/src/render.php';

if (isset($uname)) {
    echo render('profile', ['title' => "Mi Perfil", 'controller' => "$controller", 'uname' => "$uname", 'email' => "$email"]);
} else {
    header('Location: ?url=home');
}
