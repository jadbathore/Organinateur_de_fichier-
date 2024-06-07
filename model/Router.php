<?php
namespace model;

use Attribute;
use model\Twig\TwigImplementor;
use Stringable;

#[Attribute]
class Route 
{
    public function __construct(
        private ?string $route = null,
    )
    {
        $this->route = $route;
    }
}

class Stringify implements Stringable {

public function __construct(
    public string $object,
)
{ $this->object = $object; }

public function __toString(): string
{
    return $this->object;
}
}

class Router extends TwigImplementor
{
private $array;

public function __construct(
    private string $actualroute,
    private array $controllers
) {
    $this->actualroute = $actualroute;
    $this->set_attribut($controllers);
    parent::__construct();
}

private function set_attribut(array $controllers)
{
    $i = 0;
    foreach($controllers as $controller){
        $reflec_class = new \ReflectionClass($controller);
        foreach($reflec_class->getMethods() as $method){
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
        foreach($this->controllers as $controller){
            $reflec_class = new \ReflectionClass($controller);
                foreach($reflec_class->getMethods() as $method){
                $class_attributs = $reflec_class->getAttributes();
                $attributs = $method->getAttributes(Route::class);
                    foreach ($attributs as $attribut) {
                    $method_arg = $attribut->getArguments();
                    $stringfy_method_arg = new Stringify($method_arg[0]);
                    $class_arg = $class_attributs[0]->getArguments();
                    if(isset($class_arg)){
                        $stringfy_class_arg = new Stringify($class_arg[0]);
                            if($stringfy_class_arg.$stringfy_method_arg == $this->actualroute)
                            {
                                $invokable = new $method->class;
                                $reflection_method = new \ReflectionMethod($method->class,$method->name);
                                echo $reflection_method->invoke($invokable);
                                break;
                            } 
                    } else {
                        if($stringfy_method_arg == $this->actualroute)
                        {
                            $invokable = new $method->class;
                            $reflection_method = new \ReflectionMethod($method->class,$method->name);
                            echo $reflection_method->invoke($invokable);
                            break;
                        }
                    }   
            }
        }
    }
    if(!isset($invokable)){
        return false ;
    }
}

public function get_attribut()
{
    return $this->array;
}
}