<?php 

require_once './vendor/autoload.php';
require_once './public/ModelAutoloader.php';


use model\enum\Promp;

$type = Promp::type_promp($file,true);



// $raw_argv = implode(" ",$argv);


// foreach($argv as $key=>$promp)
// {
//     $type;
//     if($key == 0)
//     {
//         $type = Promp::type_promp($file,true);
//     } else {
//         $type = Promp::type_promp($file);
//     }
//     echo $promp;
//     var_dump($type);
// }
// // $argv

