<?php
namespace model\enum;

enum User
{
    case UseDocs;
    case CoddingApp;
    case Other; 
    case Error ;

    public const typeDocs = [
        "Desktop",
        "Documents",
        "Downloads",
        "Movies",
        "Library",
        "Pictures",
        "anaconda3",
        "Music",
        "Public",
        "Applications"
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
                if(in_array($file,self::typeDocs))
                {
                    return static::UseDocs;
                } else {
                    return static::Other;
                }
            }
    }
}
