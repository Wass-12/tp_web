<?php

require_once 'JsonObject.php';

class Message extends JsonObject
{
    public int $id;
    public int $salonId;
    public string $author;
    public string $content;
    public string $timestamp;

    /**
     * Crée un nouveau message
     */
    public static function create(int $salonId, string $author, string $content): self
    {
        $m = new self();
        $m->salonId = $salonId;
        $m->author = $author;
        $m->content = $content;
        $m->timestamp = date('Y-m-d H:i:s');
        return $m;
    }

    /**
     * Convertit l'objet en tableau pour l'enregistrement JSON
     */
    public function toArray(): array
    {
        return [
            "id"        => $this->id,
            "salonId"   => $this->salonId,
            "author"    => $this->author,
            "content"   => $this->content,
            "timestamp" => $this->timestamp
        ];
    }

    /**
     * Reconstruit un objet Message depuis un tableau JSON
     */
public static function fromJson(array|string $input): static
{
    // Si c’est une chaîne JSON → on la décode
    if (is_string($input)) {
        $input = json_decode($input, true);
    }

    // Si ce n’est pas un tableau → on retourne un objet vide
    if (!is_array($input)) {
        return new static();
    }

    $m = new static();
    $m->id        = $input["id"]        ?? 0;
    $m->salonId   = $input["salonId"]   ?? 0;
    $m->author    = $input["author"]    ?? "";
    $m->content   = $input["content"]   ?? "";
    $m->timestamp = $input["timestamp"] ?? "";
    return $m;
}
}