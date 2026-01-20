<?php

require_once 'JsonDb.php';
require_once 'salons.php';

class SalonDb extends JsonDb
{
    const OBJECT_CLASS = Salon::class;

    /**
     * Retourne un salon par son nom
     */
    public function getByName(string $name): Salon|false
    {
        foreach ($this->content as $salon) {
            if ($salon->$name === $name) {
                return $salon; // creer dans salons.php cependant il renconnais pas 
            }
        }
        return false;
    }
}