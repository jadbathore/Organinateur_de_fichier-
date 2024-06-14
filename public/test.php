<?php



require_once '../vendor/autoload.php';
require_once 'ModelAutoloader.php';
require 'config.php';

use main\AllFilesStatic;
use model\Attributes\CommunFunction;
use model\abstract_class\AbstractCommunVariable;
use model\Attributes\RequestMethod;
use model\Attributes\Route;
use model\enum\Image;
use model\enum\Type;
use model\Router;
use model\Stringify;

use function main\display;

// $imagick1 = getimagesize('/Users/jadbathore/Downloads/image/1-2.png');
// $imagick2 = getimagesize('/Users/jadbathore/Downloads/image/1-3.png');


// $image = imagecreatefrompng('/Users/jadbathore/Downloads/image/1-2.png');
// $image2 = imagecreatefrompng('/Users/jadbathore/Downloads/image/1-5.png');

// // var_dump($imagick1);echo '<br>';
// // var_dump($imagick2);

// try 
// {
//     $file = '/Users/jadbathore/Downloads/image/2.png';
//     var_dump($content);
//     $content = filesize($file);
//     $before = getimagesize($file);
//     echo '<h1>before</h1>';
//     echo '<pre>';
//     echo $content;
//     print_r($before);
//     echo '</pre>';
//     $bobo = Image::ImageType($file,Type::Image);
//     $img = Image::returncreateImage($bobo,$file);
//     $upadted = Image::UpdateImage($bobo,$file,$img);
//     $after = getimagesize($file);
//     $before = getimagesize($file);
//     $contentafter = filesize($file);
//     echo '<h1>after</h1>';
//     echo '<pre>';
//     echo $contentafter;
//     print_r($after);
//     echo '</pre>';
// } catch (Exception $e){
//     echo $e->getMessage();
// }







#[Route('/b')]
class test 
{
    #[Route('/a'),CommunFunction('index')]
    public function index(){
        static $ete = 2;
        static $automne = 1;
        static $hiver = 1;
        static $printemps = 1;
        
    }
    #[Route('/b'),CommunFunction('index')]
    public function test(...$test){
        echo $test['ete'];
    }
    #[Route('/c'),CommunFunction('a')]
    public function test2(...$test){
        static $a = 'hello';
    }
    #[Route('/d'),CommunFunction('a')]
    public function test3(...$test){
        echo $test['a'];
    }


}
// $test = new test([test::class]);
// $test->index();
$test_Router = new Router('/b/d',[
    test::class
]);

// abstract class testing{
//     public 
// }


$test_Router->start();
// $test_Router->communfunction();
// display($_SERVER['REQUEST_METHOD']);