<?php

namespace model\Attributes;

use Attribute;
use ReflectionAttribute;
use model\abstract_class\AbstractCommunVariable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionObject;
use stdClass;


use function main\display;

/*
*  class CommunFunction : permet de partager des données entre deux fonctions
*/ 

#[Attribute]
class CommunFunction{

    public function __construct(
        public ?string $function = null,
    )
    {
        $this->function = $function;
    }

    public function checkMethod($actualCommun,$attribut)
    {
        $argument = $attribut->getArguments();  
        if($argument[0] == $actualCommun){
            return $argument[0];
        } else {
            return false;
        }

    }
}