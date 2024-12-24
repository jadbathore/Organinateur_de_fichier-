<?php

namespace model\class\singleTone;

use model\enum\Text;
use model\interface\enum\colorInterface;
use model\interface\SingleToneInterface;

class Coloring implements SingleToneInterface
{

    private static ?Coloring $instance;

    protected function __construct()
    {}

    protected function __clone()
    {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function instance():Coloring
    {
        if(!isset(self::$instance))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function color(string $text,string $color,null|string $textmodif=null,?string $followingColor=null):void
    {
        $followingColor =(is_null($followingColor))?"\e[0m":Text::formatColoring($followingColor,$textmodif);
        $format = Text::formatColoring($color,$textmodif);
        echo $format.$text.$followingColor;
    }
}
