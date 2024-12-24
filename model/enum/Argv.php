<?php

namespace model\enum;


enum Argv:string 
{
    case Option="option";
    case Command="command";
    case Input="input";

    public static function type_Argv(string $Expected_definition):self
    {
        return match(true)
        {
            (boolval(is_bool($Expected_definition))) => static::Option,
            (boolval(preg_match('/\<[A-z]\w+\>/',$Expected_definition)))=> static::Input,
            default => static::Command,
        };
    }
}