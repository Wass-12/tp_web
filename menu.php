<?php

afficheMenu();

function afficheMenu() : void
{
    echo file_get_contents(isLogged() ? 'menu_on.html' : 'menu_off.html');
}