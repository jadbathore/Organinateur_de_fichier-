<?php

namespace model\class\ControllerHandler;

use \Error;
use model\class\IteratorAggregate\classAttributHandler_CLI;
use model\abstract\abstractAttributHandler;
use model\Attributes\Promps\Command;
use model\class\IteratorAggregate\raisedmethodHandler_CLI;
use model\class\Object\argv_CLI;
use ReflectionClass;
use model\class\Object\method_CLI;
use model\enum\Argv;

class actionControllerHandler
{

    private classAttributHandler_CLI $attributIterator;
    private raisedmethodHandler_CLI $raisedMethodIterator;
    private argv_CLI $argvObject;

    public function __construct(
        private string $controller,
        array $argv,
    ) 
    {
        $this->argvSetter($argv);
        $this->setAttributIterator();
        $this->setRaisedmethodIterator();
        if($this->argvObject->length == 0)
        {
            throw new \Error('you must promps somthing');
        }

    }

    private function setAttributIterator()
    {
        $reflec_class = new ReflectionClass($this->controller);
        $this->attributIterator = new classAttributHandler_CLI($reflec_class);
        foreach($reflec_class->getMethods() as $method)
        {
            if(!empty($method->getAttributes(Command::class)))
            {
                $methodHandler = new method_CLI($method);
                $this->attributIterator->addItem($methodHandler);
            }
        }
    }

    private function setRaisedmethodIterator()
    {
        $this->raisedMethodIterator = new raisedmethodHandler_CLI();
    }

    private function argvSetter(array $argv)
    {
        $this->argvObject = new argv_CLI(array_slice($argv,1));
    }

    public function start()
    {
        // var_dump($this->attributIterator->getIterator()->valid());
        foreach($this->attributIterator->getIterator() as $method_CLI)
        {
            if($method_CLI->getCommand() == $this->argvObject->getCurrent())
            {
                $this->argvObject->next();
                foreach($method_CLI->getOptions() ?? [] as $optionName=>$optionalPromps)
                {
                    if($this->argvObject->getCurrent() == $optionName)
                    {
                        switch($this->argvObject->currentArgvType($optionalPromps))
                        {
                            case Argv::Option:
                                $method_CLI->addPromps($optionName,true);
                            break;
                            case Argv::Input:
                                $method_CLI->addPromps($optionName,($this->argvObject->nextIsValid())?
                                $this->argvObject->getNext():true);
                                $this->argvObject->next();
                            break;
                            default:
                                
                                throw new Error('Command not expected at this level');
                        }
                        $this->argvObject->next();
                    } else {
                        $method_CLI->addPromps($optionName,null);
                    }
                }
                $this->raisedMethodIterator->addItem($method_CLI);
            }
            if(!$this->argvObject->isValid())
            {
                break 1;
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
                $raisedMethod->invokeFromPromps();
            } 
        } else {
            throw new \Error('command not found:"'.$this->argvObject->getPrompsArgv().'"');
        }
        
    }
}