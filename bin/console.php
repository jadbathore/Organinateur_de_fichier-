#!/usr/bin/env php
<?php 
require_once 'vendor/autoload.php';
require_once './public/config_Bin.php';

// require_once './public/ModelAutoloader.php';


use App\Controller\Promps\ActionController;
use App\Model\Class\ControllerHandler\BinControllerHandler;
use App\Model\Class\SingleTone\Coloring;
use App\Controller as Controllers;


try{
    $action = new BinControllerHandler(ActionController::class,$argv);
    $action->start();
}catch(Error $e){
    echo $e->getMessage();
    // Coloring::instance()->color($e->getMessage(),'red');
}

// var_dump($argv);