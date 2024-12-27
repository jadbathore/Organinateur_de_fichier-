<?php

// namespace model\class\Object;

// use model\Attributes\Promps\Command;
// use model\Attributes\Promps\Option;
// use model\class\IteratorAggregate\classAttributHandler_CLI;
// use model\class\singleTone\Coloring;
// use model\interface\methodCLIInterface;
// use \ReflectionMethod;

// class debugMethod_CLI implements methodCLIInterface {

//     private ?array $options = null;
//     private ?array $promps = null;  
//     private string $command = "debug";
//     private ReflectionMethod $method;
//     private Coloring $coloringInstance;

//     public function __construct(private classAttributHandler_CLI $classAttributHandler_CLI)
//     {
//         $this->coloringInstance = Coloring::instance();
//     }

//     private function setMethod():void
//     {
//         $this->$method = new ReflectionMethod();
//     }

//     public function getOptions(): null|array
//     {
//         return $this->options;
//     }
//     public function getCommand(): string
//     {
//         return $this->command;
//     }

//     public function addPromps(mixed $index,mixed $item):void
//     {
//     }

//     public function getPromps():null|array
//     {
//         return $this->promps;
//     }

//     public function getName():string
//     {
//         return "z";
//     }
//     public function getClass():string
//     {
//         return "a";
//     }

//     public function invokeFromPromps(): void
//     {
//     }

//     private function defaultDebugScript():void
//     {
//         $this->coloringInstance->color("CLI_File_Organisator\n","green","bold");
//         $this->coloringInstance->color("You must promps your method like this :\n","green");
//         $this->coloringInstance->color("[command] [-option] <optionalPromp> ...","green");
//         $this->coloringInstance->color(str_repeat("=", 20),"green");
//         foreach($this->$classAttributHandler_CLI->getIterator() as $method_CLI)
//         {
//             $this->coloringInstance->color("Command\n","green","underline");
//             $this->coloringInstance->color($method_CLI->getCommand()."\n","green");
//             $this->coloringInstance->color(str_repeat("-", 20),"green");
//             $this->coloringInstance->color("Option\n","green","underline");
//             $this->coloringInstance->color(implode(" ",key($method_CLI->getOptions())) ?? ""."\n","green");
//             $this->coloringInstance->color(str_repeat("=", 20),"green");
//         }
//     }

//     // #[Command('debug')]

// }