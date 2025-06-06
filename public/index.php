<?php
namespace main;

// composer start

require_once '../vendor/autoload.php';
require('config.php');


use App\Controller\HomeController;
use App\Controller\ImageController;
use App\Controller\UsersController;
use Exception;
use App\Model\Class\Binder;
use App\Model\Class\ControllerHandler\Router;
use App\Model\Class\MajorErrorHandler;

use App\Model\Class\Twig\TwigLoader;

$uri = $_SERVER['REQUEST_URI'];
$explode = explode('/',$uri);
$implode = implode('/',$explode);

$binder = new Binder($uri);

/*
pour afficher un rendu étant donné que Twig est utilisé la 
classe Router(Model/Router.php) s'occupe du rendu, le code est 
dynamique et reprend un peux le model de Symfony 
je voulait avoir des classe (model) avec des comportement perso que je crée de A à Z c'est pour ça que
je n'est pas utilsé symfony mais uniquement le moteur de template 
start s'active selon des attributs tel que :
- communFunction(method commune qui vont être rendu en meme temps il est possible que passer des
variable statique etre du method (la syntaxe + explication dans Controller))
- request method(simple get et post)
-route(selon l'url donné la method est exécuter).

gestion des erreurs :
etant donné que tout le code controller est dans un bloc try catch je peux lancer des exception à
la vollé et il seront ratrappé ici (c'est exception represent des erreur de débugage de ma par et ne devrait 
pas etre accésible coté client sauf manipe donc j'ai redirigé cette page vers une page d'erreur qui explique a
chaque cas le problème(viewer/error/errorCode.html.twig)
les erreur fatal sont prise en compte par ce système; un syteme de séverité des erreur à été mise en 
place les erreur fatal retourne un template rouge les erreur lier à twig
et les exception retourne un template orange
)
la classe abstraite abstractImplementor sert à ajouter des propriètes au classe controller tel que:
- twigObject: qui va renvoyer un object twig permettant au method (controller) de pouvoir retourné une template 
twig
- binder : qui permet d'avoir un object global binder(une classe utile perso)

*/

try{

if(!register_shutdown_function(MajorErrorHandler::errorHandler()))
{
    error_reporting(0);
    $router = new Router($implode,[
        HomeController::class,
        ImageController::class,
        UsersController::class
    ]);
    $router->start();
}
} catch(Exception $e) {
    $twigLoader = new TwigLoader();
    echo $twigLoader->twigObject->render('error/errorCode.html.twig',[
        'message_error' => $e->getMessage(),
        'error'=> $e,
        'severity'=> 0,
    ]);
}

