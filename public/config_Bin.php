<?php



namespace public;

$expoldeDir = explode('/',__DIR__);
$rootUser = implode('/',array_slice($expoldeDir,0,3));

define('ROOT_TO_DESKTOP',$rootUser.'/'.'Desktop'.'/');
define('ROOT_TO_DOWNLOAD',$rootUser .'/'.'Downloads'.'/');
define('ROOT_TO_DOCUMENT',$rootUser.'/'.'Documents'.'/');