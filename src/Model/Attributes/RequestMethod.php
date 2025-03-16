<?php

namespace App\Model\Attributes;

use Attribute;

#[Attribute]
class RequestMethod {
    public function __construct(
        private ?array $method,
    )
    {
        $this->method = $method;
    }
}
