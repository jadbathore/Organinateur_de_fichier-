<?php
require('class/Type_enum.php');
require('class/SubType_enum.php');
require('class/binder.php');
require('config.php');
require_once './vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('./viewer/');
$twig = new \Twig\Environment($loader);

$binder = new Binder();
$downloads = $binder->getFiles(ROOT_TO_DOWNLOAD);
$desktop = $binder->getFiles(ROOT_TO_DESKTOP);
$documents = $binder->getFiles(ROOT_TO_DOCUMENT);

function display_in_file($array,$directory):array
{
    foreach ($array as $file) {
    $case = Type::typefile($file);
    $types_of_files = Type::forSelect($case)['file'];
    $test['type'] = $types_of_files;
    $test['file'] = $file;
    if ($case != Type::Use_Docs) {
        if ($case == Type::Files) {
            $binder = new Binder;
            $sub_files = $binder->getFiles($directory. $file);
            $test['sub_file'] = $sub_files;
        } else {
            unset($test['sub_file']);
        }
    }else{
        unset($test['sub_file']);
    }
    $other[] = $test;
    return $other;
    }
}

$in_download = display_in_file($downloads,ROOT_TO_DOWNLOAD);
$in_Desktop = display_in_file($desktop,ROOT_TO_DESKTOP);
$in_Documents = display_in_file($documents,ROOT_TO_DOCUMENT);

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
echo'<pre>';
print_r(AllFilesStatic::definer());
echo'</pre>';
echo $twig->render('test.html.twig', [
    'path_downloads' => ROOT_TO_DOWNLOAD,
    'content_downloads' => $in_download,
]);


