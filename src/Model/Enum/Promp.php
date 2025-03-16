<?php

namespace App\Model\Enum;


enum Promp:string
{
    case download="DONWLOAD";
    case desktop="DESKTOP";
    case document="DOCUMENT";
    case undefined="UNDEFINED";

    public static function sorting_a_type(string $type): self
    {
        return (in_array(self::from($type),self::cases()))? static::undefined :self::from($type);
    }
}