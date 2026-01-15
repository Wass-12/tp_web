<?php

include 'JsonObject.php';

class Salon extends JsonObject
{
    public int $id;
    public string $name;

    public static function create(string $name): Salon
    {
        $s = new Salon();
        $s->name = $name;
        return $s;
    }
}