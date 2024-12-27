<?php

namespace model\class\Object;

use model\Attributes\Promps\Command;
use model\Attributes\Promps\Description;
use model\Attributes\Promps\Option;
use model\class\singleTone\Coloring;
use model\interface\methodCLIInterface;
use \ReflectionMethod;

class method_CLI implements methodCLIInterface {

    private ?array $options;
    private ?array $promps;
    private ?string $description;
    private string $command;
    private Object $invokable;
    private Coloring $coloringInstance;

    public function __construct(private ReflectionMethod $method)
    {
        $this->coloringInstance = Coloring::instance();
        $this->setCommand();
        $this->setOptions();
        $this->setDescription();
        $this->setInvokable();
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
        $attributes_Command = current($this->method->getAttributes(Command::class))->getArguments()[0];
        $this->command = $attributes_Command;
    }

    private function setDescription()
    {
        $condition = (($a = current($this->method->getAttributes(Description::class))) != false);
        $attributes_Description = ($condition)?$a->getArguments()[0]:null;
        $this->description = $attributes_Description;
    }

    private function setInvokable()
    {
        $className = $this->getClass();
        $this->invokable = new $className;
    }

    public function getDescription(): ?string
    {
        return (isset($this->description))? $this->description:null;
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
        if(is_null($this->getPromps()))
        {
            $this->method->invoke($this->invokable,$this->getPromps());
        } else {
            $this->method->invoke($this->invokable,...array_values($this->getPromps()));
        }
    }

    public function invoke(mixed ...$argument): void
    {
        // var_dump($argument);
        $this->method->invoke($this->invokable,...$argument);
    }

    public function method_debug_script(string $color):void 
    {
        foreach($this->method->getAttributes() as $attribut)
        {
            $basename_attribut = $this->getBaseName($attribut->getName());
            $this->coloringInstance->color($basename_attribut.":",$color,"underline","bold");
            switch($attribut->getName())
            {
                case Command::class:
                    $this->coloringInstance->color($this->getCommand(),$color,"italic");
                break;
                case Option::class:
                    $this->coloringInstance->color("<".implode(">\t<",array_keys($this->getOptions())).">",$color,"italic");
                break;
                case Description::class:
                    $this->coloringInstance->color($this->getDescription(),$color,"italic");
                break;
            }
            echo PHP_EOL;
        }
    }
    private function getBaseName(string $class):string
    {
        $explodeClass = explode("\\",$class);
        return $explodeClass[count($explodeClass)-1];
    }
}