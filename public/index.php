<?php
namespace main;

require_once '../vendor/autoload.php';
require_once 'ModelAutoloader.php';
require('config.php');


use model\Binder;
use Controller\HomeController;
use Controller\ImageController;
use model\Router;

$uri = $_SERVER['REQUEST_URI'];
$explode = explode('/',$uri);
$implode = implode('/',$explode);

$binder = new Binder($uri);
$router = new Router($implode,[
    HomeController::class,
    ImageController::class,
]);

$router->start();


