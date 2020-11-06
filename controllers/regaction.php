<?php
//Primero miramos que no este la session definida
if (!isset($_SESSION["email"]) && !isset($_SESSION["uname"])) {
    //Miramos si entrar por el boton register
    if (isset($_POST['register-button'])) {
        // Miramos que ninguno este vacio
        if (
            filter_input(INPUT_POST, 'inputUser') != null &&
            filter_input(INPUT_POST, 'inputEmail') != null &&
            filter_input(INPUT_POST, 'inputPassword') != null
        ) {
            require_once 'src/db.php';
            require_once 'config.php';
            $db = connectMysql($dsn, $dbuser, $dbpass);
            if ($db) {

                $user = filter_input(INPUT_POST, 'inputUser', FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_SPECIAL_CHARS);
                $pwd = filter_input(INPUT_POST, 'inputPassword', FILTER_SANITIZE_SPECIAL_CHARS);

                $pwd = password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 4]);

                $insert = insert($db, 'users', ['uname' => $user, 'email' => $email, 'passw' => $pwd, 'role' => 1]);

                if ($insert) {
                    header('Location: ?url=login&success');
                } else {
                    header('Location: ?url=register&error=insert');
                }
            } else {
                //Error conexion BD
                header('Location: ?url=register&error=db');
            }
        } else {
            //error vacio
            header('Location: ?url=register&error=emptyfields');
        }
    } else {
        header('Location: ?url=home');
    }
} else {
    header('Location: ?url=home');
}
