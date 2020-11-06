<?php
require APP . '/src/render.php';
$variables = ['title' => "My home", 'controller' => "$controller"];
if (isset($uname)) {
    $variables += ['uname' => "$uname", 'email' => "$email"];
}

echo render('home', $variables);
