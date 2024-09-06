<?php
namespace model;

use Stringable;


class Stringify implements Stringable
{

    public function __construct(
        public $object,
    ) {
        $this->object = $object;
    }

    public function __toString(): string
    {
        return $this->object;
    }
}