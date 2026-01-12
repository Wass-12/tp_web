<?php
include 'JsonObject.php';
include 'Salon.php';

class Salon extends JsonObject
{
       const OBJECT_CLASS = Salon::class;

    public function getByName(string $nom): Salon|false
    {
        foreach ($this->content as $s) {
            if ($s->nom === $nom) {
                return $s;
            }
        }
        return false;
    }

    public function insertSalon(Salon $s): int
    {
        return $this->insert($s);
    }

}

