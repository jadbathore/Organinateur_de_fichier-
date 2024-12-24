<?php

namespace model\class\Object;

use model\Attributes\Promps\Command;
use model\Attributes\Promps\Option;
use model\interface\methodCLIInterface;
use \ReflectionMethod;

class method_CLI implements methodCLIInterface {

    private ?array $options;
    private ?array $promps;
    private string $command;

    public function __construct(private ReflectionMethod $method)
    {
        $this->setCommand();
        $this->setOptions();
    }

    private function setOptions()
    {
        $attributes_Options = $this->method->getAttributes(Option::class);
        foreach($attributes_Options as $attribute)
        {
            $this->addOptions($attribute->getArguments()[0]);
        }
    }

    private function setCommand()
    {
        $attributes_Command = current($this->method->getAttributes(Command::class))?->getArguments()[0];
        $this->command = $attributes_Command;
    }

    public function getOptions(): null|array
    {
        return (isset($this->options))?$this->options[0]:null;
    }
    public function getCommand(): string
    {
        return $this->command;
    }

    private function addOptions(mixed $item):void
    {
        $this->options[] = $item;
    }

    public function addPromps(mixed $index,mixed $item):void
    {
        $this->promps[$index] = $item;
    }

    public function getPromps():null|array
    {
        return (isset($this->promps))?$this->promps:null; 
    }

    public function getName():string
    {
        return $this->method->name;
    }
    public function getClass():string
    {
        return $this->method->class;
    }

    public function invokeFromPromps(): void
    {
        $className = $this->getClass();
        $invokable = new $className;
        if(is_null($this->getPromps()))
        {
            $this->method->invoke($invokable,$this->getPromps());
        } else {
            $this->method->invoke($invokable,...array_values($this->getPromps()));
        }
    }
}