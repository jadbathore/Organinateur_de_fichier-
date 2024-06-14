<?php

namespace model;

use model\Attributes\CommunFunction;

class Commun {

static array $array;
static string $att_CommunFunction;

public function __construct(
    public array $controllers
)
{
    $this->controllers = $controllers;
    $this->communfunction();
}

public function communfunction()
{
    foreach ($this->controllers as $controller) {
        $reflec_class = new \ReflectionClass($controller);
        foreach ($reflec_class->getMethods() as $method) {
            $attributs = $method->getAttributes(CommunFunction::class);
            foreach($attributs as $attribut)
            {
                $instance = $attribut->newInstance();
                $variables = $instance->setVariable($method);
                if ($variables != false)
                {
                    self::$array = $variables;
                    $communAtt = $attribut->getArguments();
                    $strCommunAtt = new Stringify($communAtt[0]);
                    self::$att_CommunFunction = $strCommunAtt;
                }  
            }
            }
        }
    }
}