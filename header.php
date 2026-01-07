<?php

afficheHeader();

function afficheHeader(): void
{
    if (!isLogged()) {
        echo 'Le magnigfique header de Noël';
    } else {
        $userid = $_SESSION['userid'];
        $user = getUserById($userid);
        echo 'Salam ' . $user['login'];
    }
}