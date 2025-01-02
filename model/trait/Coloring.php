<?php

namespace model\trait;

use model\enum\Text;
use model\interface\SingleToneInterface;

trait Coloring
{
    public function color(string $text,string $color,mixed ...$modif):void
    {
        $format = Text::formatColoring($color,$modif);
        echo $format.$text."\e[0m";
    }
}

