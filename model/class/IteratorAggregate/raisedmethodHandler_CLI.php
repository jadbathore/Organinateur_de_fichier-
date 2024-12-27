<?php

namespace model\class\IteratorAggregate;

use model\iterator\AttributIterator_CLI;
use \IteratorAggregate;
use model\interface\methodCLIInterface;
use \Iterator;

class raisedmethodHandler_CLI implements IteratorAggregate
{
    private $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(methodCLIInterface $item)
    {
        $this->items[] = $item;
    }

     /**
     * @return \Traversable<TKey, methodCLIInterface>|methodCLIInterface[]
     */
    public function getIterator(): Iterator
    {
        return new AttributIterator_CLI($this);
    }

     /**
     * @return \Traversable<TKey, methodCLIInterface>|methodCLIInterface[]
     */
    public function getReverseIterator(): Iterator
    {
        return new AttributIterator_CLI($this, true);
    }
}

