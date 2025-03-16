<?php

namespace App\Model\Abstract;

use App\Model\Class\SingleTone\Organisator;
use App\Model\Trait\Coloring;

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