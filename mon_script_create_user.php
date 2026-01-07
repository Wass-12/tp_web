<?php

var_dump(password_hash('password', PASSWORD_DEFAULT));
die();

include 'deguelasDb.php';

main($argv);

function main($argv): void
{
    if (sizeof($argv) < 3) {
        echo 'Where is login and password ?' . "\n";
        exit(1);
    }
    $login = $argv[1];
    $password = $argv[2];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $id = createUser($login, $hash);
    echo "New user created with id $id\n";
}