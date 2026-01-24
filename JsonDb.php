<?php

abstract class JsonDb
{
    const DB_FOLDER = __DIR__ . '/db';

    /** @var JsonObject[] */
    protected array $content = [];

    /**
     * Retourne tous les objets
     */
    public function get(): array
    {
        return $this->content;
    }

    /**
     * Retourne un objet par son ID
     */
    public function getById(int $id): JsonObject|false
    {
        foreach ($this->content as $obj) {
            if ($obj->id === $id) {
                return $obj;
            }
        }
        return false;
    }

    /**
     * 🔍 Recherche générique : retourne tous les objets où $field == $value
     */
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

    /**
     * ✔️ Vérifie si un objet existe avec un champ donné
     */
    public function exists(string $field, mixed $value): bool
    {
        foreach ($this->content as $obj) {
            if (property_exists($obj, $field) && $obj->$field === $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Insère un objet et lui attribue un ID auto-incrémenté
     */
    public function insert(JsonObject $obj): int
    {
        $obj->id = $this->getNextId();
        $this->content[] = $obj;
        return $obj->id;
    }

    /**
     * Modifie un objet existant
     */
    public function modify(JsonObject $obj): void
    {
        foreach ($this->content as $i => $stored) {
            if ($stored->id === $obj->id) {
                $this->content[$i] = $obj;
                return;
            }
        }
    }

    /**
     * Supprime un objet par ID
     */
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

    /**
     * Sauvegarde la base dans un fichier JSON
     */
    public function save(): void
    {
        $path = self::DB_FOLDER . '/' . strtolower(static::class) . '.json';

        $array = [];
        foreach ($this->content as $obj) {
            $array[] = json_decode($obj->toJson(), true);
        }

        file_put_contents($path, json_encode($array, JSON_PRETTY_PRINT));
    }

    /**
     * Charge la base depuis un fichier JSON
     */
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
            $db->content[] = static::objectFromArray($item);
        }

        return $db;
    }

    /**
     * Convertit un tableau en objet JsonObject
     */
    protected static function objectFromArray(array $data): JsonObject
    {
        return static::OBJECT_CLASS::fromJson(json_encode($data));
    }

    /**
     * Retourne le prochain ID auto-incrémenté
     */
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