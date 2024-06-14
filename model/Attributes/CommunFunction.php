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
*  @class CommunFunction : permet de partager des données entre deux fonctions
*/ 




#[Attribute]
class CommunFunction{

    public function __construct(
        public ?string $function = null,
    )
    {
        $this->function = $function;
    }

    public function setVariable($method)
    {
        $test = new ReflectionMethod($method->class,$method->name);
        $test->setAccessible(false);
        $statics = $test->getStaticVariables();
        if(empty($statics))
        {
            return false; 
        } else {
            $variables = [];
            foreach($statics as $keys => $static)
            {
                if(is_null($static))
                {
                    if(!isset($local['class']))
                    {
                        $arg = '\model\\'.ucfirst($keys);
                        $class = new $arg();
                        display($class);
                        
                    }
                } else {
                    $variables[$keys] = $static;
                }
            }
            return $variables;
        }
    }
}