<?php
namespace main;

// require('../model/Type_enum.php');
// require('../model/SubType_enum.php');
// require('../model/Binder.php');
// require('../model/config.php');
require_once '../vendor/autoload.php';
require_once 'ModelAutoloader.php';
require('config.php');


use model\Binder;
use model\Type;
use main\AllFilesStatic;
use Controller\HomeController;
use Exception;
use model\Router;

$loader = new \Twig\Loader\FilesystemLoader('../viewer/');
$twig = new \Twig\Environment($loader);


$uri = $_SERVER['REQUEST_URI'];
$explode = explode('/',$uri);
$implode = implode('/',$explode);

$binder = new Binder($uri);
$router = new Router($implode,[
    HomeController::class,
]);

$router->start();


