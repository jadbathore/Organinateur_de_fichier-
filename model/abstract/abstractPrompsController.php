<?php

namespace model\abstract;

use model\class\singleTone\Organisator;
use model\class\singleTone\Coloring;

abstract class abstractPrompsController
{
    private Coloring $coloringInstance;
    private Organisator $organisatorInstance;

    public function __construct() 
    {
        $this->organisatorInstance = Organisator::instance();
        $this->coloringInstance = Coloring::instance();
    }

    public function getOrganisator():Organisator
    {
        return $this->organisatorInstance;
    }

    protected function setOrganisator(string $path):void
    {
        Organisator::_init_($path);
    }

    public function getColoring():Coloring
    {
        return $this->coloringInstance;
    }
} 