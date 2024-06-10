<?php

namespace model\Attributes;

use Attribute;

#[Attribute]
class RequestMethod {
    public function __construct(
        private string|array $method = null,
    )
    {
        $this->method = $method;
    }
}
