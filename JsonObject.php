<?php

abstract class JsonObject
{
    public function toJson(): string
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    /**
     * @throws Exception
     */
    public static function fromJson(string $str): static
    {
        $json = json_decode($str);

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
