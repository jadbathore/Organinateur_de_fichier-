<?php

namespace model\class\IteratorAggregate;

use model\iterator\AttributIterator_CLI;
use \IteratorAggregate;
use model\interface\methodCLIInterface;
use \Iterator;

class classAttributHandler_CLI implements IteratorAggregate
{
    private $items = [];

    
    public function __construct(private \ReflectionClass $method) 
    {}

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(methodCLIInterface $item)
    {
        $this->items[] = $item;
    }

    public function getIterator(): Iterator
    {
        return new AttributIterator_CLI($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new AttributIterator_CLI($this, true);
    }

    
}