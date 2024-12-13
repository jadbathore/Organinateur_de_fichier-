<?php 

require_once './vendor/autoload.php';
require_once './public/ModelAutoloader.php';

use Controller\Promps\ActionController;
use model\class\actionControllerHandler;

try{
    $action = new actionControllerHandler(ActionController::class,$argv);
    $action->start();
}catch(Error $e){
    echo $e;
}

