<?php
namespace main;

require_once '../vendor/autoload.php';
require_once 'ModelAutoloader.php';
require('config.php');


use model\Binder;
use Controller\HomeController;
use Controller\ImageController;
use Exception;
use model\Router;
use model\Twig\TwigLoader;

$uri = $_SERVER['REQUEST_URI'];
$explode = explode('/',$uri);
$implode = implode('/',$explode);

$binder = new Binder($uri);


try{
    $router = new Router($implode,[
        HomeController::class,
        ImageController::class,
    ]);

    $router->start();
} catch(Exception $e) {
    $twigLoader = new TwigLoader();
     echo $twigLoader->twigObject->render('error/errorCode.html.twig',[
        'message_error' => $e->getMessage(),
        'error'=> $e,
    ]);
}

