<?php

function getDb(): PDO
{
    try {
        return new PDO('mysql:host=localhost;dbname=tp_php', 'root', 'password');
    } catch (Exception $e) {
        echo "Échec : " . $e->getMessage();
    }
}

function authenticate(string $login, string $password): int
{
    $sql = 'SELECT id_user, password FROM user WHERE login=:login';
    $select = getDb()->prepare($sql);
    $select->execute([
        'login' => $login
    ]);
    $res = $select->fetch();
    if(!password_verify($password, $res['password'])){
        return -1;
    }
    return $res['id_user'];
}

function createUser(string $login, string $password) : int
{
    $sql = 'INSERT INTO user (login, password) VALUES(:login, :password);';
    $pdo = getDb();
    $select = $pdo->prepare($sql);
    $select->execute([
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
    return $pdo->lastInsertId();
}

function getUserById(int $id) : array
{
    $sql = 'SELECT id_user, login, password FROM user WHERE id_user=:id;';
    $select = getDb()->prepare($sql);
    $select->execute([
        'id' => $id
    ]);
    $res = $select->fetch();
    return $res ?? [];
}

function kifeFort() : void
{
    if(!isLogged()){
        return;
    }
    $userId = $_SESSION['userid'];
    $sql = 'INSERT INTO kifekoi (id_user, url, date) VALUES(:id_user, :url, UNIX_TIMESTAMP())';
    $insert = getDb()->prepare($sql);
    $insert->execute([
        'id_user' => $userId,
        'url' => $_SERVER['REQUEST_URI']
    ]);
}

function kiAffiche() : array {
    $sql = 'SELECT id_user, url, date FROM kifekoi ORDER BY date';
    $select = getDb()->prepare($sql);
    $select->execute();
    return $select->fetchAll();
}