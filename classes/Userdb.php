<?php

include 'JsonDb.php';
include 'User.php';

class UserDb extends JsonDb
{
    const OBJECT_CLASS = User::class;

    /**
     * Trouve un utilisateur par email
     */
    public function getByEmail(string $email): User|false
    {
        foreach ($this->content as $u) {
            if ($u->email === $email) {
                return $u;
            }
        }
        return false;
    }

    /**
     * Ajoute un utilisateur
     */
    public function insertUser(User $u): int
    {
        return $this->insert($u);
    }
}