<?php

namespace model\class;

use Error;
use model\class\method_CLI;
use model\class\IteratorAggregate\classAttributHandler_CLI;
use model\abstract\abstractAttributHandler;
use model\class\IteratorAggregate\raisedmethodHandler_CLI;
use ReflectionClass;


class actionControllerHandler extends abstractAttributHandler
{

    private classAttributHandler_CLI $attributIterator;
    private raisedmethodHandler_CLI $raisedMethodIterator;

    public function __construct(
        private string $controller,
        private array $argv,
    ) 
    {
        $this->argvSetter($argv);
        $this->setAttributIterator();
        $this->setRaisedmethodIterator();
        if(count($this->argv) == 0)
        {
            throw new Error('you must promps somthing');
        }

    }

    private function setAttributIterator()
    {
        $reflec_class = new ReflectionClass($this->controller);
        $this->attributIterator = new classAttributHandler_CLI($reflec_class);
        foreach($reflec_class->getMethods() as $method)
        {
            $methodHandler = new method_CLI($method);
            $this->attributIterator->addItem($methodHandler);
        }
    }

    private function setRaisedmethodIterator()
    {
        $this->raisedMethodIterator = new raisedmethodHandler_CLI();
    }

    private function argvSetter(array $argv)
    {
        $this->argv = array_slice($argv,1);
    }

    public function start()
    {
        foreach($this->attributIterator->getIterator() as $method_CLI)
        {
            if(current($this->argv) == $method_CLI->getCommand())
            {
                next($this->argv);
                if(str_contains(current($this->argv),"-"))
                {   
                    $optionalPromps = [];
                    foreach($method_CLI->getOptions() as $name=>$optionalPromps)
                    {
                        if(current($this->argv) == $name)
                        {
                            next($this->argv);
                            if(preg_match('/\<[A-z]\w+\>/',$optionalPromps ?? '') !== false)
                            {
                            $trueValue = boolval(true);
                            $method_CLI->addPromps($name,(current($this->argv)== false)?$trueValue: current($this->argv));
                            } else {
                            $method_CLI->addPromps($name,$optionalPromps);
                            }
                        } 
                    }
                }
                $this->raisedMethodIterator->addItem($method_CLI);
            }
            print_r($method_CLI->getPromps());

            if(current($this->argv)== false)
            {
                break;
            }
        }

        $this->invokeAllRaisedMethod();
    }


    private function invokeAllRaisedMethod()
    {
        if(!empty($this->raisedMethodIterator->getItems()))
        {
            foreach($this->raisedMethodIterator->getIterator() as $raisedMethod)
            {
                $className = $raisedMethod->getClass();
                $invokable = new $className;
                $reflection = new \ReflectionMethod($raisedMethod->getClass(),$raisedMethod->getName());
                $reflection->invoke($invokable,$raisedMethod->getPromps());
            }
        } else {
            throw new Error('command not found:"'.implode(' ',$this->argv).'"');
        }
        
    }
}