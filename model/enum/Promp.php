<?php

namespace model\enum;


enum Promp:string {
    case download="DONWLOAD";
    case desktop="DESKTOP";
    case document="DOCUMENT";
    case undefined="UNDEFINED";


    public static function type_promp(string $type): static
    {
        
        
        return (in_array(self::from($type),self::cases()))? static::undefined :self::from($type);
    }
}