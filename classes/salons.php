<?php
include 'classes/JsonObject.php';
include 'classes/User.php';
class Salon extends JsonObject
{
    public string $nom;

    public static function create(string $nom): Salon
    {
        $salon = new Salon();
        $salon->nom = $nom;
        return $salon;
    }
}

