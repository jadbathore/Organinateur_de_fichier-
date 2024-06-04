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

$loader = new \Twig\Loader\FilesystemLoader('../viewer/');
$twig = new \Twig\Environment($loader);

$binder = new Binder();

$controller = new HomeController();
echo $controller->index();


