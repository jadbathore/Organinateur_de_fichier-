<?php 

namespace model\abstract;

use model\PrompsHandler;

abstract class abstractAttributHandler 
{
    private $attributes = [];

    abstract public function  start();

    public function addToAttributes(\ReflectionMethod $method):void
    {
        $attributs = $method->getAttributes();
        foreach ($attributs as $attribut){
            $name = $attribut->getName();
            $argument = $this->flatten($attribut->getArguments());
            $this->attributes[$name][] = $this->flatten($argument);
        }
    }

    public function flatten(array $array) {
        $return = array();
        array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
        return $return;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
    
}