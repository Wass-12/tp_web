<?php

include 'JsonObject.php';

class User extends JsonObject
{
    public int $id;

    public string $pseudo;
    public string $password;
    public string $email;


    public static function create(string $pseudo, string $password, string $email): User
    {
        $u = new User();
        $u->pseudo = $pseudo;
        $u->password = password_hash($password, PASSWORD_DEFAULT);
        $u->email = $email;
        return $u;
    }
}
