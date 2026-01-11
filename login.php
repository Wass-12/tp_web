<?php

$login = $_POST['login'];
$password = $_POST['password'];

$userId = -1;
if (isset($_POST['create'])) {
    $userId = createUser($login, $password);
} else {
    $userId = authenticate($login, $password);
}

if ($userId == -1) {
    error_log('Login fail account ' . $login . ' from ' . $_SERVER['REMOTE_ADDR']);
    header('Location: /');
    die();
}
session_start();
$_SESSION['userid'] = $userId;
header('Location: /wtf');