<?php

namespace model;

use model\Attributes\CommunFunction;

use function main\display;

class Commun {

static array $array;
static string $att_CommunFunction;
static string $method_name_commun;
static string $method_class_commun;

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
                $variables = $instance->checkMethod($method,$attribut);
                
                if ($variables != false)
                {
                    self::$method_class_commun = $method->class;
                    self::$method_name_commun = $method->name;
                }
            }
        }
    }
    if (!isset($variables))
    {
        
    }
}
}