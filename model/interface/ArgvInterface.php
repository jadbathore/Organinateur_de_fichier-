<?php

namespace model\interface;

use model\enum\Argv;

interface argvInterface {
    public function getCurrent():string;
    public function getNext():string;
    public function isValid():bool;
    public function nextIsValid():bool;
    public function currentArgvType(string|bool $expected_definition):Argv;
    public function getPrompsArgv():string;
    public function next():void;
}