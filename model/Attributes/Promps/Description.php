<?php

namespace model\Attributes\Promps;

use Attribute;

#[Attribute]
class Exaemple {
    public function __construct(
        private string|array $method = null,
    )
    {
        $this->method = $method;
    }
}