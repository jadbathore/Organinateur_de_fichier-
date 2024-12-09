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
        try {
            require($base_DIR . $test.'.php');
        } catch (\Throwable $e) {
            echo "This was caught: " . $e->getMessage();
        }
    }
}

ModelAutoloading::register();