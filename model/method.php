<?php

namespace model;

use Attribute;

#[Attribute]
class method {
    public function __construct(
        private string|array $method = null,
    )
    {
        $this->method = $method;
    }
}
