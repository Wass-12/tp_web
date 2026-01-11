<?php

include_once 'JsonObject.php';

class User extends JsonObject
{
    public string $login;
    public string $password;
    public string $email;

    public static function create(string $login, string $password, string $email): User
    {
        $u = new User();
        $u->login = $login;
        $u->password = password_hash($password, PASSWORD_DEFAULT);
        $u->email = $email;
        return $u;
    }
}
