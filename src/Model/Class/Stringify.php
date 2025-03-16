<?php
namespace App\Model\Class;

use Stringable;


class Stringify implements Stringable
{

    public function __construct(
        public mixed $object,
    ) {
        $this->object = $object;
    }

    public function __toString(): string
    {
        return $this->object;
    }
}