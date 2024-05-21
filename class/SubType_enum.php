<?php

use function PHPSTORM_META\type;

enum SubType:int 
{
    case php = 0;
    case python = 1;
    case javascript = 2;
    case html_css = 3;
    case cpp = 4;
    case c = 5;
    case swift = 6;
    case angular = 7;
    case Error = 8;
    case Unidentified = 9;

    public static function typesubfile(string $file,Type $fileTypes): static
    {
        $keys_word = [
            'php' => ['index.php'],
            'python' => ['main.py','app.py'],
            'javascript' => ['script.js'],
            'html' => ['index.html','style.css','bootstrap'],
            'cpp' => ['main.cpp','inculde.hpp','hpp','bin'],
            '_c' => ['main.c'],
            'swift' => ['swift','playground','.swift'],
            'angular' => ['angular.json'],
        ];
        if ($fileTypes == Type::Files)
        {
            if(in_array($file,$keys_word))
            {
                return match(true)
                {
                    stristr($file,'php') => static::php,
                    str_contains($file,key($keys_word['python'])) => static::python,
                    str_contains($file,key($keys_word['javascript'])) => static::javascript,
                    str_contains($file,key($keys_word['html'])) => static::html_css,
                    str_contains($file,key($keys_word['cpp'])) => static::cpp,
                    str_contains($file,key($keys_word['_c'])) => static::c,
                    str_contains($file,key($keys_word['swift'])) => static::swift,
                    str_contains($file,key($keys_word['angular'])) => static::angular,
                    
                };
            } else {
                $binder = new Binder;
                $inspection_file = $binder->getFiles(PATH_TO_DOWNLOAD.$file);
                return match (true)
                {
                    (count(array_intersect($keys_word['php'],$inspection_file)) == 1)  => static::php,
                    (count(array_intersect($keys_word['python'],$inspection_file)) >= 1)  => static::python,
                    (count(array_intersect($keys_word['javascript'],$inspection_file)) >= 1)  => static::javascript,
                    (count(array_intersect($keys_word['html'],$inspection_file)) >= 2)  => static::html_css,
                    (count(array_intersect($keys_word['cpp'],$inspection_file)) >= 1)  => static::cpp,
                    (count(array_intersect($keys_word['_c'],$inspection_file)) == 1)  => static::c,
                    (count(array_intersect($keys_word['swift'],$inspection_file)) >= 1)  => static::swift,
                    (count(array_intersect($keys_word['angular'],$inspection_file)) == 1)  => static::angular,
                    default => static::Unidentified
                };
            }
        }
        
        
    }
}