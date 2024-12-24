<?php

namespace model\enum;

use Error;
use model\interface\enum\colorInterface;

enum Text:string implements colorInterface
{
    case TextModif="TextModif";
    case Coloring="Coloring";
    case bgColoring="BgColoring";
    case Error="Error";

    private static function type_text(string $input):self
    {
        return match(true)
        {
            (str_contains($input,"bg"))=> static::bgColoring,
            (in_array($input,self::Colour))=>static::Coloring,
            (in_array($input,self::acceptableTextModif))=>static::TextModif,
            default=>static::Error,
        };
    }

    static public function formatColoring(string $input,?string $textmodif = null):string
    {
        $getType = self::type_text($input);
        $food = 'cake';
        $return_value = match ($getType) {
            self::bgColoring => "4",
            self::Coloring => "3",
            default=> throw new Error("type no allowed.for input($getType)")
        };
        if($getType == self::bgColoring)
        {
            $input = implode(explode('bg',$input));
        }
        $key = array_search($input,self::Colour);
        $textmodification = (($f = array_search($textmodif,self::acceptableTextModif))!= false)?";".$f:'';
        return "\e[".$return_value.$key.$textmodification."m";
    }
}