<?php

namespace App\Model\class;

use Exception;
use App\Model\Attributes\CommunFunction;


class Commun {

static array $array;
static string $att_CommunFunction;
static string $method_name_commun;
static string $method_class_commun;
static string $argument_Attribut;

public function __construct(
    public array $controllers,
    public string $actualCommun,
)
{
    $this->controllers = $controllers;
    $this->communfunction($actualCommun);
}

public function communfunction($actualCommun)
{
    foreach ($this->controllers as $controller) {
        $reflec_class = new \ReflectionClass($controller);
        foreach ($reflec_class->getMethods() as $method) {
            $attributs = $method->getAttributes(CommunFunction::class);
            foreach($attributs as $attribut)
            {
                $instance = $attribut->newInstance();
                $variables = $instance->checkMethod($actualCommun,$attribut);
                if (($variables != false) and ($variables == $method->name) )
                {
                    self::$method_class_commun = $method->class;
                    self::$method_name_commun = $method->name;
                    self::$argument_Attribut = $variables;
                }
            }
        }
    }
    if(!isset($variables))
    {
        throw new Exception('aucune variable à ce nom');
    }
}
}