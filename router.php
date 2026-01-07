<?php

const DEFAULT_PAGE = 'content_off.html';

const LOGGEDCSUR = [
    'wtf',
    'admin'
];

const ROUTES = [
    '' => DEFAULT_PAGE,
    'merde' => 'inscription.html',
    'wtf' => 'content_on.html',
    'admin' => 'admin.php'
];
const CTL = [
    'login' => 'login.php',
    'logout' => 'logout.php'
];

function ilFautLogged() : void
{
    $lurl = trim($_SERVER['REQUEST_URI'], '/');
    if (!in_array($lurl, LOGGEDCSUR)) {
        return;
    }
    if(isLogged()){
        return;
    }
    header('Location: /');
    die();
}

function checkCtl() : void
{
    $lurl = trim($_SERVER['REQUEST_URI'], '/');
    if (!array_key_exists($lurl, CTL)) {
        return;
    }
    includePage(CTL[$lurl]);
    die();
}

function gps(): void
{
    $lurl = trim($_SERVER['REQUEST_URI'], '/');
    if (!array_key_exists($lurl, ROUTES)) {
        includePage(DEFAULT_PAGE);
        error_log('default page');
    }
    if (pathinfo(ROUTES[$lurl], PATHINFO_EXTENSION) == 'php') {
        includePage(ROUTES[$lurl]);
        return;
    }
    if (pathinfo(ROUTES[$lurl], PATHINFO_EXTENSION) == 'html') {
        echo file_get_contents(ROUTES[$lurl]);
        return;
    }
    // TODO cas non géré
}

function includePage(string $page): void
{
    if (!is_file($page)) {
        http_response_code(500);
        error_log('Machi la page ! Arrrrgghhhh...');
        echo 'Machi la page ! Arrrrgghhhh...';
    }
    include $page;
}

function isLogged(): bool
{
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    return !empty($_SESSION['userid']);
}