<?php

namespace model\iterator;

use \Iterator;
use model\class\IteratorAggregate\classAttributHandler_CLI;
use model\class\IteratorAggregate\raisedmethodHandler_CLI;
use model\interface\methodCLIInterface;

class AttributIterator_CLI implements \Iterator
{
    private classAttributHandler_CLI|raisedmethodHandler_CLI $collection;
    private $index = 0;

    /**
     * @var bool This variable indicates the traversal direction.
     */
    private $reverse = false;

    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function rewind():void
    {
        $this->index = $this->reverse ? count($this->collection->getItems()) - 1 : 0;
    }

    public function current():methodCLIInterface
    {
        return $this->collection->getItems()[$this->index];
    }

    public function key():int
    {
        return $this->index;
    }

    public function next():void
    {
        $this->index = $this->index + ($this->reverse ? -1 : 1);
    }

    public function valid():bool
    {
        return isset($this->collection->getItems()[$this->index]);
    }
}