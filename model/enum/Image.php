<?php

namespace model\enum;

use Exception;
use GdImage;

enum Image:string {

    case Gif = 'gif';
    case Jpg = 'jpeg';
    case Png = 'png';
    case Svg = 'svg';
    case webp = 'webp';
    case avif = 'avif';
    case Error = '';

    public static function ImageType(string $image,Type $fileType)
    {
        if($fileType != Type::Image)
        {
            return static::Error;
        } else {
            if(explode('.',$image)[1] != 'svg')
            {
                if(($mime = getimagesize($image)['mime']))
                {
                    $silcedmime = explode('/',$mime);
                    foreach(self::cases() as $case)
                    {
                        $stringcases[] = $case->value;
                    };
                    return match(true)
                    {
                        ($mime== false) => static::Svg,
                        in_array($silcedmime[1],$stringcases) => static::from($silcedmime[1]),
                        default => static::Error
                    };
                } else {
                    return static::Error;
                }
            } else {
                return static::Svg;
            }
        }
    }

    public static function returncreateImage(self $typeImage,string $image)
    {
        return match ($typeImage)
        {
            self::Gif => imagecreatefromgif($image),
            self::Jpg => imagecreatefromjpeg($image),
            self::Png => imagecreatefrompng($image),
            self::Svg => throw new Exception('svg ne peux pas etre compresser'),
            self::webp => imagecreatefromwebp($image),
            self::avif => imagecreatefromavif($image),
            self::Error => throw new Exception("$image n'est pas une image")
        };
    }

    public static function UpdateImage(self $typeImage,string $image,GdImage $createdImage)
    {
        return match ($typeImage)
        {
            self::Gif => throw new Exception("les fichiers gif ne peux pas etre réduit : $image"),
            self::Jpg => imagejpeg($createdImage,$image,60),
            self::Png => imagepng($createdImage,$image,8),
            self::webp => imagewebp($createdImage,$image,60),
            self::avif => imageavif($createdImage,$image,30),
            self::Svg => throw new Exception("les fichiers svg ne peux pas etre réduit : $image"),
            self::Error => throw new Exception("$image n'est pas une image")
        };
    }

    public static function nameSelected(self $typeImage):string
    {
        return $typeImage->value;
    }
}