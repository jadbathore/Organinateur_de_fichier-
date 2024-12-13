<?php

namespace model\interface;

interface methodCLIInterface {
    public function getOptions(): null|array;
    public function getCommand(): string;
    public function getName():string;
    public function getClass():string;
    public function addPromps(mixed $index,mixed $item):void;
    public function getPromps():null|array;
}