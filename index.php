<?php
require('class/enum.php');
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
        // var_dump(Type::typefile($files));
        $test = $binder->slicesFiles($type_of_File,$files);
        // echo $test.'<br>';
        
    }

};

foreach(Type::cases() as $case)
{
    var_dump($case);
    echo '<pre>';
    print_r(Type::forSelect($case));
    echo '</pre>';
    
}

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
    
