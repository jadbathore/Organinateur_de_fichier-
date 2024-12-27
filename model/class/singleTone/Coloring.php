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

    
    public function color(string $text,string $color,mixed ...$modif):void
    {
        $format = Text::formatColoring($color,$modif);
        echo $format.$text."\e[0m";
    }
}
