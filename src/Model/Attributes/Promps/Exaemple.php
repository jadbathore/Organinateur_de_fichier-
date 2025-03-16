<?php

namespace App\Model\Attributes\Promps;

use Attribute;

#[Attribute]
class Command {
    public function __construct(
        private ?string $method=null,
    )
    {
        $this->method = $method;
    }
}