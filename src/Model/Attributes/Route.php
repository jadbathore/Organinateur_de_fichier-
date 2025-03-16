<?php
namespace App\Model\Attributes;

use Attribute;

#[Attribute]
class Route 
{
    public function __construct(
        private ?string $route,
    )
    {
        $this->route = $route;
    }
}