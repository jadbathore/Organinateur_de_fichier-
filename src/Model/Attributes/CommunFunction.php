<?php

namespace App\Model\Attributes;

use Attribute;

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