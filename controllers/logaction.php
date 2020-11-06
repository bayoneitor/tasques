<?php
//Primero miramos que no este la session definida
if (!isset($_SESSION["email"]) && !isset($_SESSION["uname"])) {
    //Miramos si viene por login y si viene por cookie le damos otros parametros arriba
    if (isset($_POST['login-button'])) {
        // Miramos que ninguno este vacio
        if (filter_input(INPUT_POST, 'inputEmail') != null || filter_input(INPUT_POST, 'inputPassword') != null) {
            require_once 'src/db.php';
            require_once 'config.php';

            $email = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_SPECIAL_CHARS);
            $pwd = filter_input(INPUT_POST, 'inputPassword', FILTER_SANITIZE_SPECIAL_CHARS);
            $db = connectMysql($dsn, $dbuser, $dbpass);
            if ($db) {
                //Selecciona el email
                $log = auth($db, $email, $pwd);
                if ($log == true) {
                    if (isset($_POST['remember-me'])) {
                        //Recordamos el email
                        setcookie("email", $email, time() + 60 * 60 * 24 * 365, "/");
                    } else {
                        setcookie("email", "", time() - 1, "/");
                    }
                    header('Location: ?url=home&success');
                } else {
                    header('Location: ?url=login&error=notExists');
                }
            } else {
                //Error conexion BD
                header('Location: ?url=login&error=db');
            }
        } else {
            //Elementos vacios
            header('Location: ?url=login&error=emptyfields');
        }
    } else {
        header('Location: ?url=home');
    }
} else {
    header('Location: ?url=home');
}
