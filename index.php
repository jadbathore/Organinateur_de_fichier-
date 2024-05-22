<?php
require('class/Type_enum.php');
require('class/SubType_enum.php');
require('class/binder.php');
require('config.php');
$binder = new Binder();
$downloads = $binder->getFiles(PATH_TO_DOWNLOAD);
$create = $binder->createFile();
$i = 2;
foreach ($downloads as $key => $files) {
    if(type::typefile($files) != Type::Use_Docs)
    {
        $type_of_File = type::typefile($files);
        $test = $binder->slicesFiles($type_of_File,$files);        
    }

};

foreach(SubType::cases() as $case)
{
    var_dump($case);
    echo '<pre>';
    print_r(SubType::forSelect_sub($case));
    echo '</pre>';
}
// var_dump(SubType::typesubfile('avancer',Type::Files));

// $file = 'cours_angular';
// $keys_word = array(
//     'php' => ['index.php'],
//     'python' => ['main.py','app.py'],
//     'javascript' => ['script.js'],
//     'html' => ['index.html','style.css','bootstrap'],
//     'cpp' => ['main.cpp','inculde.hpp','hpp','bin'],
//     '_c' => ['main.c'],
//     'swift' => ['swift','playground','.swift'],
//     'angular' => ['angular.json'],
// );
// function test($filee,$array)
// {
//     foreach($array as $term => $value)
//     {
//         if(stristr($filee,$term)){
            
//             return $term;
//         }
//     }
//     return false;
// } 
// test($file,$keys_word);


// {
// // echo $slice_file.'<br>';
//     if(strstr($file,'php'))
//     {
//         echo 'test ok';
//     } else {
//         echo'test no ok';
//     }
// }

// $test = $binder->createFile();
//  echo '<pre>';
// print_r($test);
//  echo '</pre>';

// $alldefine = get_defined_constants(true)['user'];
// echo '<pre>';
// print_r(Type::forSelect(Type::Error));
// echo '</pre>';

// var_dump(Type::typefile('docs'));
;

// echo '<pre>';
// print_r(AllFilesStatic::definer());
// echo '</pre>';

// echo '<pre>';
// print_r($downloads);
// echo '<pre>';
    
