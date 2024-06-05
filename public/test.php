<?php



$imagick1 = getimagesize('/Users/jadbathore/Downloads/image/1-2.png');
$imagick2 = getimagesize('/Users/jadbathore/Downloads/image/1-3.png');


$image = imagecreatefrompng('/Users/jadbathore/Downloads/image/1-2.png');
$image2 = imagecreatefrompng('/Users/jadbathore/Downloads/image/1-5.png');

var_dump($imagick1);echo '<br>';
var_dump($imagick2);
$test = imagecreatetruecolor(round(600 * 1), round(343 * 1));

// var_dump($image);  
// imagepng($image,'/Users/jadbathore/Downloads/image/1-2.png',9);

