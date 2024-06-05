<?php

class ModelAutoloading
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__,'autoloading'));
    }

    static function autoloading($class){
    if(stristr($class,'model')){
        if($explode_class = explode("\\",$class)){
            $last_array_value = end($explode_class);
            if(count($explode_class) < 3)
            {
                require '../model/'.$last_array_value.'.php';
            } else {
                $strings_dir = array_slice($explode_class,1);
                $first_dir = current($strings_dir);
                $require_dir = "../model/";
                foreach($strings_dir as $string)
                {
                    if($string == $first_dir)
                    {
                        $require_dir .= $string;
                    } else {
                        $require_dir .= '/'.$string;
                    }
                }
                require_once $require_dir.'.php';
            }
        }
        
        } elseif(stristr($class,'controller')){
            if($explode_class = explode("\\",$class)){
                $last_array_value = end($explode_class);
                if(count($explode_class) < 3)
                {
                    require '../Controller/'.$last_array_value.'.php';
                } else {
                    $strings_dir = array_slice($explode_class,1);
                    $first_dir = current($strings_dir);
                    $require_dir = "../Controller/";
                    foreach($strings_dir as $string)
                    {
                        if($string == $first_dir)
                        {
                            $require_dir .= $string;
                        } else {
                            $require_dir .= '/'.$string;
                        }
                    }
                    require_once $require_dir.'.php';
                }
            }
        }
    }
}
ModelAutoloading::register();

