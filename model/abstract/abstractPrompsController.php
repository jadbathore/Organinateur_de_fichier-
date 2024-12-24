<?php

namespace model\abstract;

use model\class\Organisator;
use model\class\singleTone\Coloring;

abstract class abstractPrompsController
{
    private Coloring $coloringInstance;
    private Organisator $organisator;

    public function __construct() 
    {
        $this->organisator = new Organisator();
        $this->coloringInstance = Coloring::instance();
    }

    public function getOrganisator():Organisator
    {
        return $this->organisator;
    }

    protected function setOrganisator(string $path):void
    {
        $this->organisator = new Organisator($path);
    }

    public function getColoring():Coloring
    {
        return $this->coloringInstance;
    }
} 