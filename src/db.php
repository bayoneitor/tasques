<?php
function connectMysql(string $dsn, string $userdb, string $passdb): PDO
{
    try {
        $db = new PDO($dsn, $userdb, $passdb);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    return $db;
}
function auth($db, $email, $pass): bool
{
    try {
        //preparem sentència
        $stmt = $db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $count = $stmt->rowCount();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // ha trobat incidència
        if ($count == 1) {
            $user = $row[0];
            $res = password_verify($pass, $user['passw']);

            if ($res) {
                // establim sessió
                $_SESSION['uname'] = $user['uname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['id'] = $user['id'];
                // retornem true
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

// funció d'inserció de registres en taula
function insert($db, $table, array $data): bool
{
    if (is_array($data)) {
        $columns = '';
        $bindv = '';
        $values = null;
        foreach ($data as $column => $value) {
            $columns .= '`' . $column . '`,';
            $bindv .= '?,';
            $values[] = $value;
        }
        $columns = substr($columns, 0, -1);
        $bindv = substr($bindv, 0, -1);

        $sql = "INSERT INTO {$table}({$columns}) VALUES ({$bindv})";

        try {
            $stmt = $db->prepare($sql);

            $stmt->execute($values);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

        return true;
    }
    return false;
}

// funció de selecció de  tots els registres
// pots indicar quins camps vols mostrar
function selectAll($db, $table, array $fields = null): array
{
    if (is_array($fields)) {
        $columns = implode(',', $fields);
    } else {
        $columns = "*";
    }

    $sql = "SELECT {$columns} FROM {$table}";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
// select amb join sense condició
function selectAllWithJoin($db, $table1, $table2, array $fields = null, string $join1, string $join2): array
{
    if (is_array($fields)) {
        $columns = implode(',', $fields);
    } else {
        $columns = "*";
    }

    $inners = "{$table1}.{$join1} = {$table2}.{$join2}";

    $sql = "SELECT {$columns} FROM {$table1} INNER JOIN {$table2} ON {$inners}";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
// select amb join amb només una condició
function selectWhereWithJoin($db, $table1, $table2, array $fields = null, string $join1, string $join2, array $conditions): array
{
    if (is_array($fields)) {
        $columns = implode(',', $fields);
    } else {
        $columns = "*";
    }

    $inners = "{$table1}.{$join1} = {$table2}.{$join2}";
    $cond = "{$conditions[0]}='{$conditions[1]}'";

    $sql = "SELECT {$columns} FROM {$table1} INNER JOIN {$table2} ON {$inners} WHERE {$cond} ";


    $stmt = $db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
// funcion de borrar con condición
function delete($db, $table, array $conditions = null): bool
{
    if (is_array($conditions)) {
        $cond = 'WHERE ';
        foreach ($conditions as $column => $value) {
            $cond .= "{$column} = '{$value}' AND ";
        }
        $cond = substr($cond, 0, -5);
    } else {
        $cond = '';
    }


    $sql = "DELETE FROM {$table} {$cond}";
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
    return true;
}
// funció d'inserció de registres en taula
function update($db, $table, array $set, array $conditions): bool
{

    if (is_array($conditions) && is_array($set)) {
        //set
        $update = '';
        foreach ($set as $column => $value) {
            $update .= "{$column} = '{$value}',";
        }
        $update = substr($update, 0, -1);
        //Where
        $cond = '';
        foreach ($conditions as $column => $value) {
            $cond .= "{$column} = '{$value}' AND ";
        }
        $cond = substr($cond, 0, -5);

        $sql = "UPDATE {$table} SET {$update} WHERE {$cond}";
        try {
            $stmt = $db->prepare($sql);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

        return true;
    }
    return false;
}
