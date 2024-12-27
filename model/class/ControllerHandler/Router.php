<?php

namespace model\class\ControllerHandler;

use Exception;
use model\Attributes\CommunFunction;
use ReflectionClass;
use model\Attributes\Route;
use model\Attributes\RequestMethod;
use model\abstract\AbstractImplementor;
use model\class\Stringify;
use model\class\Commun;

class Router extends AbstractImplementor
{
    private $array;

    public function __construct(
        private string $actualroute,
        public array $controllers,
        
    ) {
        $this->actualroute = $actualroute;
        $this->set_attribut($controllers);
        parent::__construct();
    }

    private function set_attribut(array $controllers)
    {
        $i = 0;
        foreach ($controllers as $controller) {
            $reflec_class = new ReflectionClass($controller);
            foreach ($reflec_class->getMethods() as $method) {
                $attributs = $method->getAttributes(Route::class);
                $classArray[$method->class][$i]['attribut'] = $attributs;
                $classArray[$method->class][$i]['method'] = $method;
                foreach ($attributs as $attribut) {
                    $route = $attribut->getArguments();
                    $classArray[$method->class][$i]['route'] = $route[0];
                    $i++;
                }
            }
        }
        return $this->array = $classArray;
    }

    public function start()
    {
        foreach ($this->controllers as $controller) {
            $reflec_class = new ReflectionClass($controller);
            foreach ($reflec_class->getMethods() as $method) {
                $class_attributs = $reflec_class->getAttributes();
                $attributs = $method->getAttributes(Route::class);
                foreach ($attributs as $attribut) {
                    $method_arg = $attribut->getArguments();
                    $stringfy_method_arg = new Stringify($method_arg[0]);
                    if(isset($class_attributs[0]))
                    {
                        $class_arg = $class_attributs[0]->getArguments();
                    }
                        if(($this->testrequestMethod($method) == $_SERVER['REQUEST_METHOD']) or ($this->testrequestMethod($method) == false))
                        {
                            if (isset($class_arg)) {
                            $stringfy_class_arg = new Stringify($class_arg[0]);
                            if ($stringfy_class_arg . $stringfy_method_arg == $this->actualroute) {
                                $invokable = new $method->class;
                                $reflection_method = new \ReflectionMethod($method->class, $method->name);
                                if ($method->getAttributes(CommunFunction::class))
                                {
                                    $agr_Commun = $method->getAttributes(CommunFunction::class)[0]
                                                        ->getArguments();
                                    new Commun($this->controllers,$agr_Commun[0]);
                                        if ($agr_Commun[0] == Commun::$argument_Attribut)
                                        {
                                            if($method->name == Commun::$method_name_commun)
                                            {
                                                echo $reflection_method->invoke($invokable);
                                            } else {
                                                $invokable_commun = new Commun::$method_class_commun();
                                                $commun_class_reflection = new \ReflectionMethod(Commun::$method_class_commun,Commun::$method_name_commun);
                                                echo $commun_class_reflection->invoke($invokable_commun);
                                                $statics = $commun_class_reflection->getStaticVariables();
                                                if(!empty($statics)){
                                                    echo $reflection_method->invokeArgs($invokable,$statics);
                                                    die();
                                                }else {
                                                    echo $reflection_method->invoke($invokable);
                                                    die();
                                                }
                                            }
                                        }  else {
                                            throw new Exception("aucune autre methode n'a d'attribut communFunction: $agr_Commun[0]");
                                            die();
                                        }
                                } else {
                                    echo $reflection_method->invoke($invokable);
                                }
                            }
                        } else {
                            if ($stringfy_method_arg == $this->actualroute) {
                                $invokable = new $method->class;
                                $reflection_method = new \ReflectionMethod($method->class, $method->name);
                                if ($method->getAttributes(CommunFunction::class))
                                {
                                    $agr_Commun= $method->getAttributes(CommunFunction::class)[0]
                                                        ->getArguments();
                                    if ($agr_Commun[0] == commun::$att_CommunFunction)
                                    {
                                        echo $reflection_method->invokeArgs($invokable,Commun::$array);
                                    } 
                                } else {
                                    echo $reflection_method->invoke($invokable);
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }
        if(!isset($invokable)){
            echo $this->twigObject->render('error/errorRoute.html.twig',[
                'route' => $this->actualroute
            ]) ;
        }
    }

    public function communfunction()
    {
        foreach ($this->controllers as $controller) {
            $reflec_class = new ReflectionClass($controller);
            foreach ($reflec_class->getMethods() as $method) {
                $attributs = $method->getAttributes(CommunFunction::class);
            }
        }
    }

    private function testrequestMethod($methodAttr = null)
    {
            $attributs = $methodAttr->getAttributes(RequestMethod::class);
            foreach ($attributs as $attribut) {
                $method = $attribut->getArguments();
                if (count($method) >= 2) {
                    return false;
                } else {
                    $stringfy_req_method = new Stringify($method[0]);
                    return $stringfy_req_method;
                }
            }
            if(!isset($method)){
                return false;
            }
    }

    public function get_attribut()
    {
        return $this->array;
    }
    
}
