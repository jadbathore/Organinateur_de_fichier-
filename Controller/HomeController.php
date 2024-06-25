<?php
namespace Controller;


use model\Binder;
use main\AllFilesStatic;
use model\Attributes\CommunFunction;
use model\Attributes\RequestMethod;
use model\Attributes\Route;
use model\enum\Type;
use model\Twig\AbstractImplementor;

use function main\display;

#[Route('/')]
class HomeController extends AbstractImplementor 
{
    #[Route(''),RequestMethod('GET'),CommunFunction('index')]
    function index()
    {
        $downloads = $this->binder->getFiles(ROOT_TO_DOWNLOAD);
        $desktop = $this->binder->getFiles(ROOT_TO_DESKTOP);
        $documents = $this->binder->getFiles(ROOT_TO_DOCUMENT);
        AllFilesStatic::test(ROOT_TO_DOCUMENT);
        $allfiles = [];
        $allfiles['downloads'][] = $this->display_in_file($downloads, ROOT_TO_DOWNLOAD);
        $allfiles['downloads'][] = AllFilesStatic::definer()['roots'][0];
        $allfiles['desktop'][] = $this->display_in_file($desktop, ROOT_TO_DESKTOP);
        $allfiles['desktop'][] = AllFilesStatic::definer()['roots'][1];
        $allfiles['documents'][] = $this->display_in_file($documents, ROOT_TO_DOCUMENT);
        $allfiles['documents'][] = AllFilesStatic::definer()['roots'][2];
        static $file_downloads = serialize($downloads);
        static $file_desktop = serialize($desktop);
        static $file_documents = serialize($documents);
        return $this->twigObject->render('home/index.html.twig', [
            'content_downloads' => $allfiles,
        ]);
    }

    #[Route(''),RequestMethod('POST'),CommunFunction('index')]
    public function indexPost(...$sharedstatics)
    {
        if(!isset($_POST['file_to_organize']))
        {
            return $this->flashMessage('veuiller choisir un fichier à organisé','error');
        } else {
            $pass_response = $sharedstatics['file_'.$_POST['file_to_organize']];
            $to_organize = unserialize($pass_response);
            $this->binder->createFile();
            foreach ($to_organize as $files) 
            {
                if (Type::typefile($files) != Type::Use_Docs) {
                    $type_of_File = Type::typefile($files);
                    $this->binder->slicesFiles($type_of_File, $files);
                }
            };
            return $this->flashMessage('les fichiers on bien été rangé','success');
        } 
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
