<?php

abstract class JsonObject
{
    public function toJson(): string
    {
        return json_encode(get_object_vars($this));
    }

    public static function fromJson(array|string $input): static
    {
        // Si c'est une string JSON → on la décode
        $json = is_string($input) ? json_decode($input) : (object) $input;

        if ($json === null) {
            throw new Exception('Bad json input');
        }

        $obj = new static();

        foreach (get_class_vars(static::class) as $name => $value) {
            if (!isset($json->$name)) {
                throw new Exception("Missing parameter $name");
            }
            $obj->$name = $json->$name;
        }

        return $obj;
    }
}