<?php
namespace model\enum;

use main\AllFilesStatic;
use model\class\Binder;

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
    case Unidentified = 8;
    case Error = 9;

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
            if(($test = self::test_string($file,$keys_word)) != false)
            {
                return match(true)
                {
                    ($test == 'php') => static::php,
                    ($test == 'python') => static::python,
                    ($test == 'javascript') => static::javascript,
                    ($test == 'html') => static::html_css,
                    ($test == 'cpp') => static::cpp,
                    ($test == '_c') => static::cpp,
                    ($test == 'swift') => static::swift,
                    ($test == 'angular') => static::angular,
                };
            } else {
                $binder = new Binder;
                $inspection_file = $binder->getFiles(ROOT_TO_DOWNLOAD.$file);
                if($inspection_file != self::Unidentified){
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
                } else {
                    return static::Unidentified;
                }
            }
        } else {
            return static::Error;
        }
    }

    private static function test_string($file,$array)
    {
        foreach($array as $term => $value)
        {
            if(stristr($file,$term)){
                return $term;
            }
        }
        return false;
    }

    public static function ForSelect_sub(self $case)
    {
        return match($case)
        {
            self::Error => ['error'],
            self::Unidentified => 
            [
                'file' => AllFilesStatic::definer()['files'][7],
                'path' => AllFilesStatic::definer()['paths'][7],
            ],
            $case => [
                'file' => AllFilesStatic::definer()['sub_files'][$case->value],
                'path' => AllFilesStatic::definer()['sub_paths'][$case->value],
                ]
        };
    }
}