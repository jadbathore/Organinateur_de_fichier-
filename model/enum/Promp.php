<?php

namespace model\enum;


enum Promp:string {

    case ApplicationName="Application name";
    case option="option";
    case command="command";

    public static function type_promp(string $file,bool $first_promps = false): static
    {
        switch(true){
            case $first_promps :return static::ApplicationName;break;
            case (str_contains($file,"-")):return static::option;break;
            default: return static::command;
        }
    }
}