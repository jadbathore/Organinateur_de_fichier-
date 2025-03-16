<?php

namespace App\Model\Attributes\Promps;

use Attribute;

#[Attribute]
class Option {
    public function __construct(
        private ?array $method=null,
    )
    {
        $this->method = $method;
    }
}