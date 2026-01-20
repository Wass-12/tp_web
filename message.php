<?php

require_once 'JsonObject.php';

class Message extends JsonObject
{
    public int $id;
    public int $salonId;
    public string $author;
    public string $content;
    public string $timestamp;

    public static function create(int $salonId, string $author, string $content): Message
    {
        $m = new Message();
        $m->salonId = $salonId;
        $m->author = $author;
        $m->content = $content;
        $m->timestamp = date('Y-m-d H:i:s');
        return $m;
    }
}