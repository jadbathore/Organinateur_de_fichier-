<?php

namespace model\class\Object;

use model\enum\Argv;
use model\interface\argvInterface;

class argv_CLI implements argvInterface {

    private int $index = 0;
    public int $length;

    public function __construct(
        private array $argv
    )
    {
        $this->length = count($this->argv);
    }

    public function getCurrent():string
    {
        return ($this->isValid())?$this->argv[$this->index]:$this->argv[$this->length -1];
    }

    public function isValid():bool
    {
        return isset($this->argv[$this->index]);
    }

    public function getNext():string
    {
        return $this->argv[($this->nextIsValid())?$this->index+1:$this->length - 1];
    }

    public function nextIsValid():bool
    {
        return isset($this->argv[$this->index + 1]);
    }


    public function currentArgvType(string|bool $expected_definition):Argv
    {
        return Argv::type_Argv($expected_definition);
    }

    public function next():void
    {
        $this->index++;
    }
    public function getPrompsArgv():string
    {
        return implode(' ',$this->argv);
    }
}