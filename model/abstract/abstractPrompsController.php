<?php

namespace model\abstract;

use model\class\singleTone\Organisator;
use model\trait\Coloring;

abstract class abstractPrompsController
{
    use Coloring;

    private Organisator $organisatorInstance;

    public function __construct() 
    {
        $this->organisatorInstance = Organisator::instance();
    }

    public function getOrganisator():Organisator
    {
        return $this->organisatorInstance;
    }

    protected function setOrganisator(string $path):void
    {
        Organisator::_init_($path);
    }

} 