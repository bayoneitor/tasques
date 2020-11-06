
<?php
require APP . '/src/render.php';

if (isset($uname)) {
    require 'src/db.php';
    require 'config.php';
    $db = connectMysql($dsn, $dbuser, $dbpass);
    if ($db) {
        //Miramos si ha entrado por el boton de añadit o actualizar, ya que al final lo que cambia es el sql lo demás igual
        if (isset($_POST['add-button']) || isset($_POST['edit-button'])) {
            // Miramos que ninguno este vacio
            if (filter_input(INPUT_POST, 'description') != null || filter_input(INPUT_POST, 'date') != null) {
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);

                //Miramos si es el boton de añadir, si es así le hacemos un inser si no, miramos que sea el de editar
                if (isset($_POST['add-button'])) {
                    $sql = insert($db, 'task', ['description' => $description, 'user' => $id, 'due_date' => $date]);
                } else if (isset($_POST['edit-button'])) {
                    $idTask = filter_input(INPUT_POST, 'idTask', FILTER_SANITIZE_SPECIAL_CHARS);
                    $sql = update($db, 'task', ['description' => $description, 'due_date' => $date], ["id" => $idTask, "user" => $id]);
                }

                if ($sql == true) {
                    header('Location: ?url=dashboard&success');
                } else {
                    header('Location: ?url=dashboard&error');
                }
            }
            //Miramos si ha entrado por enlace y si es así miramos que sea el de delete y que tenga el id
        } else if (isset($_REQUEST['action'])) {
            if ($_REQUEST['action'] == "delete" && $_REQUEST['id'] != null) {
                $delete = delete($db, 'task', ["id" => $_REQUEST['id'], "user" => $id]);
                if ($delete) {
                    header('Location: ?url=dashboard');
                } else {
                    header('Location: ?url=dashboard&error');
                }
            } else {
                header('Location: ?url=dashboard&error');
            }
        }
    } else {
        header('Location: ?url=dashboard');
    }
} else {
    header('Location: ?url=home');
}
