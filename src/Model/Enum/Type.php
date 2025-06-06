<?php
namespace App\Model\Enum;

use Main\AllFilesStatic;

enum Type: int 
{
    case Image = 0;
    case Coding = 1;
    case Object = 2;
    case Calc = 3;
    case Docs = 4;
    case Audio_Video = 5;
    case Unidentified = 6;
    case Files = 7 ;
    case Use_Docs = 8;
    case MacsSpecialFile = 9;
    case Error = 10;

    public const typeDocs = [
        'docs' => ['docx', 'doc', 'txt', 'pdf'],
        'object' => ['blend', 'obg','hdr','glb'],
        'calc' => ['xml', 'csv', 'xslx'],
        'audio_video' => ['mp3', 'wav', 'ram', 'mpg', 'mp4'],
        'image' => ['gif', 'jpg', 'jpeg', 'png', 'svg'],
        'code' => ['php', 'cpp', 'js', 'py', 'html', 'css'],
    ];

    public const stringvalue = 
    ['image',
    'coding',
    'object',
    'calc',
    'docs',
    'audio_video',
    'Unidentified',
    'file',
    'use_docs',
    'MacsSpecialFile',
    'Error',
];

    public static function typefile(string $file): static
    {
        switch(true){
            case ($file == '.localized'): return static::MacsSpecialFile;break;
            case ($file == '.DS_Store'): return static::MacsSpecialFile;break;
            case (str_contains($file,'.')): 
                $silcedfile = explode('.', $file);
                return match (true) {
                    in_array($silcedfile[1], self::typeDocs['docs']) => static::Docs,
                    in_array($silcedfile[1], self::typeDocs['object']) => static::Object,
                    in_array($silcedfile[1], self::typeDocs['calc']) => static::Calc,
                    in_array($silcedfile[1], self::typeDocs['audio_video']) => static::Audio_Video,
                    in_array($silcedfile[1], self::typeDocs['code']) => static::Coding,
                    in_array($silcedfile[1], self::typeDocs['image']) => static::Image,
                    default => static::Unidentified
                };break;
            case(in_array($file,AllFilesStatic::definer()['files'])): return static::Use_Docs;
            default : return static::Files;
        }

    }


    public static function forSelect(self $case):array
    {
    return match($case)
        {
        self::Error => ['error'],
        self::Use_Docs => ['file' => 'app_docs'],
        self::MacsSpecialFile => ['file'=> 'MacOs'],
        self::Files => 
        [
            'file' => AllFilesStatic::definer()['files'][$case->value],
            'path' => AllFilesStatic::definer()['paths'][$case->value],
            'sub_files' =>  AllFilesStatic::definer()['sub_paths'],
            'sub_paths' =>  AllFilesStatic::definer()['sub_files'],
        ],
        $case => 
            [
                'file' => AllFilesStatic::definer()['files'][$case->value],
                'path' => AllFilesStatic::definer()['paths'][$case->value]
            ],
        };
    }

    public static function stringcases(self $cases)
    {
        return self::stringvalue[$cases->value];
    }
}

