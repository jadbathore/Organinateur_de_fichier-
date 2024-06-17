<?php
namespace Controller;

use model\Binder;
use main\AllFilesStatic;
use model\Attributes\CommunFunction;
use model\Attributes\RequestMethod;
use model\Attributes\Route;
use model\enum\Type;
use model\Twig\twigImplementor;

use function main\display;

#[Route('/')]
class HomeController extends TwigImplementor
{
    #[Route(''),RequestMethod('GET'),CommunFunction('index')]
    function index()
    {
        static $z = 1;
        $binder = new Binder();
        $downloads = $binder->getFiles(ROOT_TO_DOWNLOAD);
        $desktop = $binder->getFiles(ROOT_TO_DESKTOP);
        $documents = $binder->getFiles(ROOT_TO_DOCUMENT);
        AllFilesStatic::test(ROOT_TO_DOWNLOAD);
        $allfiles = [];
        $allfiles['downloads'][] = $this->display_in_file($downloads, ROOT_TO_DOWNLOAD);
        $allfiles['downloads'][] = AllFilesStatic::definer()['roots'][0];
        $allfiles['desktop'][] = $this->display_in_file($desktop, ROOT_TO_DESKTOP);
        $allfiles['desktop'][] = AllFilesStatic::definer()['roots'][1];
        $allfiles['documents'][] = $this->display_in_file($documents, ROOT_TO_DOCUMENT);
        $allfiles['documents'][] = AllFilesStatic::definer()['roots'][2];
        return $this->twigObject->render('home/index.html.twig', [
            'content_downloads' => $allfiles,
        ]);
    }

    #[Route(''),RequestMethod('POST'),CommunFunction('index')]
    function indexPost()
    {
        // $binder = new Binder();
        // $downloads = $binder->getFiles(ROOT_TO_DOWNLOAD);
        // $desktop = $binder->getFiles(ROOT_TO_DESKTOP);
        // $documents = $binder->getFiles(ROOT_TO_DOCUMENT);
        // $create = $binder->createFile();
        // $i = 2;
        // foreach ($downloads as $key => $files) {
        //     if (Type::typefile($files) != Type::Use_Docs) {
        //         $type_of_File = Type::typefile($files);
        //         $test = $binder->slicesFiles($type_of_File, $files);
        //     }
        // };
    }
    public function display_in_file($array, $directory): array
    {
        foreach ($array as $file) {
            $case = Type::typefile($file);
            $types_of_files = Type::forSelect($case)['file'];
            $test['type'] = $types_of_files;
            $test['file'] = $file;
            if ($case != Type::Use_Docs) {
                if ($case == Type::Files) {
                    $binder = new Binder;
                    $sub_files = $binder->getFiles($directory . $file);
                    $test['sub_file'] = $sub_files;
                } else {
                    unset($test['sub_file']);
                }
            } else {
                unset($test['sub_file']);
            }
            $test['root'] = $directory . $file;
            $other[] = $test;
        }
        return $other;
    }
}
