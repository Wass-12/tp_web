<?php

require_once 'JsonDb.php';
require_once 'message.php';

class MessageDb extends JsonDb
{
    const OBJECT_CLASS = Message::class;

    /**
     * Retourne tous les messages d'un salon
     */
    public function getBySalonId(int $salonId): array
    {
        $result = [];
        foreach ($this->content as $message) {
            if ($message->salonId === $salonId) {
                $result[] = $message;
            }
        }
        return $result;
    }

    /**
     * Retourne tous les messages d'un auteur
     */
    public function getByAuthor(string $author): array
    {
        $result = [];
        foreach ($this->content as $message) {
            if ($message->author === $author) {
                $result[] = $message;
            }
        }
        return $result;
    }
}

