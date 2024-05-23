<?php
require('class/Type_enum.php');
require('class/SubType_enum.php');
require('class/binder.php');
require('config.php');
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('./viewer/');
$twig = new \Twig\Environment($loader);

$binder = new Binder();
$downloads = $binder->getFiles(PATH_TO_DOWNLOAD);
foreach ($downloads as $key => $file) {
    $case = Type::typefile($file);
    $types_of_files = Type::forSelect($case)['file'];
    $test['type'] = $types_of_files;
    $test['file'] = $file;
    if ($case != Type::Use_Docs) {
        if ($case == Type::Files) {
            $sub_files = $binder->getFiles(PATH_TO_DOWNLOAD . $file);
            $test['sub_file'] = $sub_files;
        } else {
            unset($test['sub_file']);
        }
    }else{
        unset($test['sub_file']);
    }
    $other[] = $test;
}
if(isset($_POST['sub']))
{
$create = $binder->createFile();
$i = 2;
foreach ($downloads as $key => $files) {
    if(type::typefile($files) != Type::Use_Docs)
    {
        $type_of_File = type::typefile($files);
        $test = $binder->slicesFiles($type_of_File,$files);        
    }
};
}
echo $twig->render('test.html.twig', ['path' => PATH_TO_DOWNLOAD, 'content_downloads' => $other]);



// foreach(SubType::cases() as $case)
// {
//     var_dump($case);
//     echo '<pre>';
//     print_r(SubType::forSelect_sub($case));
//     echo '</pre>';
// }
