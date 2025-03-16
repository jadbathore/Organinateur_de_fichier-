<?php

namespace App\Model\Enum;

use Error;
use App\Model\Interface\Enum\EnumFileInterface;

enum File: string implements EnumFileInterface
{
    case Image = 'image';
    case Coding = 'coding';
    case Object = 'Object';
    case Calc = 'calcul';
    case Docs = 'docs';
    case Audio_Video = 'Audio_Video';
    case Unidentified = 'Unidentified';
    case Files = 'files' ;
    case Compressible = 'Compressible';
    case Use_Docs = 'use Docs';
    case Font = 'font';
    case EmptyFile = 'empty file';
    case Package = 'package';
    case MacsSpecialFile = 'MacsSpecialFile';
    case Error = 'Error';

    public const notSuitableCase = [
        self::Use_Docs,
        self::MacsSpecialFile,
        self::Error,
        self::EmptyFile,
    ];

    public static function sorting_a_type(string $fileName,string|bool $mineType): self
    {
        switch(true){
            case (basename($fileName) == '.localized'): return static::MacsSpecialFile;break;
            case (basename($fileName) == '.DS_Store'): return static::MacsSpecialFile;break;
            case(self::is_useFile($fileName)): return static::Use_Docs;
            default : 
            if(count(explode("/",$mineType)) == 1)
            {
                return match($mineType){
                    'directory' => static::Files,
                    default => static::Error,
                };
            } else {
                $info = explode("/",$mineType);
                return match (true) {
                    ($info[0] == 'image') => static::Image,
                    ($info[1] == 'zip') => static::Compressible,
                    ($info[0] == 'font') => static::Font,
                    ($info[1] == 'x-xar') => static::Package,
                    in_array($info[1], self::typeDocs['docs']) => static::Docs,
                    in_array($info[1], self::typeDocs['object']) => static::Object,
                    in_array($info[1], self::typeDocs['calc']) => static::Calc,
                    in_array($info[1], self::typeDocs['audio_video']) => static::Audio_Video,
                    in_array($info[1], self::typeDocs['code']) => static::Coding,
                    default => static::Unidentified
                };
            }
            break;
        }
    }

    public static function is_useFile(string $file)
    {
        $arrayFile = explode('/',$file);
        $stack_condition = (count($arrayFile) == 5);
        $is_a_Case_condition = self::tryCases($arrayFile[count($arrayFile)-1]);
        return ($stack_condition && $is_a_Case_condition);
    }

    private static function tryCases(string $case):bool
    {
        try {
            self::from($case);
            return true;
        }catch(Error){
            return false;
        } 
    }

    public static function select(self $case):string
    {
        return $case->value;
    }

    public static function sutableFileCase(self $case):bool
    {
        if(!in_array($case,self::notSuitableCase))
        {
            return true;
        } else {
            return false;
        }
    }
}