<?php

namespace model\enum;

use Exception;
use GdImage;
use model\Stringify;

enum Image {

    case Gif;
    case Jpg;
    case Png;
    case Svg;
    case Error;

    public static function ImageType(string $image,Type $fileType)
    {
        if($fileType != Type::Image)
        {
            return static::Error;
        } else {
            $silcedImage = explode('.',$image);
            return match(true)
            {
                ($silcedImage[1] == 'gif') => static::Gif,
                (($silcedImage[1] == 'jpg') or ($silcedImage[1] == 'jpeg')) => static::Jpg,
                ($silcedImage[1] == 'png') => static::Png,
                ($silcedImage[1] == 'svg') => static::Svg,
            };
        }
    }

    public static function returncreateImage(self $typeImage,string $image)
    {
        return match ($typeImage)
        {
            self::Gif => imagecreatefromgif($image),
            self::Jpg => imagecreatefromjpeg($image),
            self::Png => imagecreatefrompng($image),
            self::Svg => 'svg ne peux pas etre compresser',
            self::Error => throw new Exception("$image n'est pas une image")
        };
    }

    public static function UpdateImage(self $typeImage,string $image,GdImage $createdImage)
    {
        return match ($typeImage)
        {
            self::Gif => imagegif($createdImage,$image,9),
            self::Jpg => imagejpeg($createdImage,$image,9),
            self::Png => imagepng($createdImage,$image,9),
            self::Svg => throw new Exception("les fichiers svg ne peux pas etre réduit"),
            self::Error => throw new Exception("$image n'est pas une image")
        };
    }

    public static function nameSelected(self $typeImage,Type $type = Type::Image):string
    {
        return match ($typeImage)
        {
            self::Gif => 'gif',
            self::Jpg => 'jpg',
            self::Png => 'png',
            self::Svg => 'svg',
            self::Error => 'error',
        };
    }

}