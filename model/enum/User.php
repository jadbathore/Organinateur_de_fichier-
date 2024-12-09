<?php
namespace model\enum;

enum User: string
{
    case SourceFile = 'Source file';
    case CoddingApp = 'CoddingAPP';
    case Other = 'Other document '; 
    case ToNotDisplay = 'NONE';
    case Error = 'Error';

    public const typeDocs = [
        "Desktop",
        "Documents",
        "Downloads",
        "Movies",
        "Pictures",
        "Music",
        "Public",
        "anaconda3"
    ];

    public const ToNotDisplayfile = [
        "Library",
        "Applications",
        "anaconda3"
    ];

    public static function typefile(string $file): static
    {
            if(str_contains($file,'.'))
            {
                $silcedfile = explode('.', $file);
                if(empty($silcedfile[0]))
                {
                    return static::CoddingApp;
                } else {
                    return static::Other;
                }
            } else {
                switch(true)
                {
                    case(in_array($file,self::typeDocs)):return static::SourceFile;break;
                    case(in_array($file,self::ToNotDisplayfile)):return static::ToNotDisplay;break;
                    default : return static::Other;
                }
            }
    }
    public static function nameSelected(self $typeImage):string
    {
        return $typeImage->value;
    }
}
