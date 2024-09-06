<?php
namespace model\Attributes;

use Attribute;

#[Attribute]
class Route 
{
    public function __construct(
        private ?string $route = null,
    )
    {
        $this->route = $route;
    }
}