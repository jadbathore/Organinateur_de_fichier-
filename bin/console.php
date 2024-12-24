#!/usr/bin/env php
<?php 

require_once './public/ModelAutoloader.php';
require_once  './public/config_Bin.php';

use Controller\Promps\ActionController;
use model\class\ControllerHandler\actionControllerHandler;

try{
    $action = new actionControllerHandler(ActionController::class,$argv);
    $action->start();
}catch(Error $e){
    echo $e->getMessage();
}
