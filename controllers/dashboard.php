
<?php
require APP . '/src/render.php';

if (isset($uname)) {
    echo render('dashboard', ['title' => "Mi Lista", 'controller' => "$controller", 'css' => 'dashboard', 'uname' => "$uname", 'email' => "$email"]);
} else {
    header('Location: ?url=home');
}
