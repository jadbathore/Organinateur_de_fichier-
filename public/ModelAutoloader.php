<?php

class ModelAutoloading
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__,'autoloading'));
    }

    static function autoloading($class){
        $explode_class = $explode_class = explode("\\",$class);
        $test = implode('/',$explode_class);
        $base_DIR = implode(explode('public',__DIR__));
        $class_DIR = $base_DIR . $test.".php";
        try {
            require $class_DIR;
        } catch (\Throwable $e) {
            echo "\e[31m"." This was caught:\n".$class_DIR. "\e[0m"."\n";
        }
    }
}

ModelAutoloading::register();