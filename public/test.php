<?php

use model\enum\Image;
use model\enum\Type;

require_once 'ModelAutoloader.php';


$imagick1 = getimagesize('/Users/jadbathore/Downloads/image/1-2.png');
$imagick2 = getimagesize('/Users/jadbathore/Downloads/image/1-3.png');


$image = imagecreatefrompng('/Users/jadbathore/Downloads/image/1-2.png');
$image2 = imagecreatefrompng('/Users/jadbathore/Downloads/image/1-5.png');

// var_dump($imagick1);echo '<br>';
// var_dump($imagick2);

try 
{
    $file = '/Users/jadbathore/Downloads/image/2.png';
    var_dump($content);
    $content = filesize($file);
    $before = getimagesize($file);
    echo '<h1>before</h1>';
    echo '<pre>';
    echo $content;
    print_r($before);
    echo '</pre>';
    $bobo = Image::ImageType($file,Type::Image);
    $img = Image::returncreateImage($bobo,$file);
    $upadted = Image::UpdateImage($bobo,$file,$img);
    $after = getimagesize($file);
    $before = getimagesize($file);
    $contentafter = filesize($file);
    echo '<h1>after</h1>';
    echo '<pre>';
    echo $contentafter;
    print_r($after);
    echo '</pre>';
} catch (Exception $e){
    echo $e->getMessage();
}

// var_dump($bobo);
// var_dump($image);  
// imagepng($image,'/Users/jadbathore/Downloads/image/1-2.png',9);
