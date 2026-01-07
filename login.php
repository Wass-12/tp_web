<?php

$login = $_GET["login"];
$password = $_GET["password"];

echo "Votre login est : ".$login;
echo "<br>";
echo "Votre mot de passe est : ".$password;

if (isset ( $_GET ["login"] )) {
    $login = $_GET ["login"];
    if (! empty ( $login )) {
        echo "Votre login est : " . $login;
        echo "<br>";
    }
}
if (isset ( $_GET ["password"] )) {
    $password = $_GET ["password"];
    if (! empty ( $password )) {
        echo "Votre mot de passe est : " . $password;
    }
}
function getVar($name) {
    if (isset ( $_GET [$name] )) {
        if(is_numeric($tab[$name])){
            return $tab[$name];
        }
        if (! empty ( $_GET [$name] )) {
            return $_GET [$name];
        }
        return TRUE;
    }
    return FALSE;
}

function postVar($name)
{
    if (isset ($_POST [$name])) {
        if (is_numeric($tab[$name])) {
            return $tab[$name];
        }
        if (!empty ($_POST[$name])) {
            return $_POST[$name];
        }
        return TRUE;
    }
    return FALSE;
}