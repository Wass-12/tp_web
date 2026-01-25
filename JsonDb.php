<?php

abstract class JsonDb
{
    const DB_FOLDER = __DIR__ . '/db';

    /** @var JsonObject[] */
    protected array $content = [];

    public function get(): array
    {
        return $this->content;
    }

    public function getById(int $id): JsonObject|false
    {
        foreach ($this->content as $obj) {
            if ($obj->id === $id) {
                return $obj;
            }
        }
        return false;
    }

    public function getBy(string $field, mixed $value): array
    {
        $result = [];
        foreach ($this->content as $obj) {
            if (property_exists($obj, $field) && $obj->$field === $value) {
                $result[] = $obj;
            }
        }
        return $result;
    }

    public function exists(string $field, mixed $value): bool
    {
        foreach ($this->content as $obj) {
            if (property_exists($obj, $field) && $obj->$field === $value) {
                return true;
            }
        }
        return false;
    }

    public function insert(JsonObject $obj): int
    {
        $obj->id = $this->getNextId();
        $this->content[] = $obj;
        return $obj->id;
    }

    public function modify(JsonObject $obj): void
    {
        foreach ($this->content as $i => $stored) {
            if ($stored->id === $obj->id) {
                $this->content[$i] = $obj;
                return;
            }
        }
    }

    public function delete(int $id): JsonObject|false
    {
        foreach ($this->content as $i => $obj) {
            if ($obj->id === $id) {
                $deleted = $obj;
                array_splice($this->content, $i, 1);
                return $deleted;
            }
        }
        return false;
    }

    public function save(): void
    {
        $path = self::DB_FOLDER . '/' . strtolower(static::class) . '.json';

        $array = [];
        foreach ($this->content as $obj) {
            $array[] = json_decode($obj->toJson(), true);
        }

        file_put_contents($path, json_encode($array, JSON_PRETTY_PRINT));
        echo "Écriture dans : " . realpath($path);
    }
    

    public static function load(): static
    {
        $path = self::DB_FOLDER . '/' . strtolower(static::class) . '.json';

        $db = new static();

        if (!is_file($path)) {
            return $db;
        }

        $raw = json_decode(file_get_contents($path), true);

        if (!is_array($raw)) {
            return $db;
        }

        foreach ($raw as $item) {

            if (is_string($item)) {
                $item = json_decode($item, true);
            }

            if (is_array($item)) {
                $db->content[] = static::objectFromArray($item);
            }
        }

        return $db;
    }

    protected static function objectFromArray(array $data): JsonObject
    {
        return static::OBJECT_CLASS::fromJson($data);
    }

    private function getNextId(): int
    {
        $max = 0;
        foreach ($this->content as $obj) {
            if ($obj->id > $max) {
                $max = $obj->id;
            }
        }
        return $max + 1;
    }
}