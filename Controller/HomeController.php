<?php
namespace Controller;

use Exception;
use model\Binder;
use main\AllFilesStatic;
use model\Attributes\CommunFunction;
use model\Attributes\RequestMethod;
use model\Attributes\Route;
use model\enum\Type;
use model\Twig\AbstractImplementor;

use function main\display;

/*
home controller permet d'afficher pour de ranger les fichiers,
au niveau de Commun function: 
les statique (cela ne peux etre que des string ou des int) sont passer de cette manière,
je crée une static exemple : 
#[communfunction(method1)]
method1()
{
    static $a = 1
    echo 2.'<br>'; 
}
puis pour la method target je passe cette static en argument 
#[communfunction(method1)]
method2(...$sharedA)
{
puis je peux réutilisé cela : 

echo $sharedA['a']

affiche :
2
1

}

)
*/

#[Route('/')]
class HomeController extends AbstractImplementor 
{
    #[Route(''),RequestMethod('GET'),CommunFunction('index')]
    function index()
    {
        $downloads = $this->binder->getFiles(ROOT_TO_DOWNLOAD);
        $desktop = $this->binder->getFiles(ROOT_TO_DESKTOP);
        $documents = $this->binder->getFiles(ROOT_TO_DOCUMENT);
        $allfiles = [];
        $allfiles['downloads'][] = $this->display_in_file($downloads, ROOT_TO_DOWNLOAD);
        $allfiles['downloads'][] = ROOT_TO_DOWNLOAD;
        $allfiles['desktop'][] = $this->display_in_file($desktop, ROOT_TO_DESKTOP);
        $allfiles['desktop'][] = ROOT_TO_DESKTOP;
        $allfiles['documents'][] = $this->display_in_file($documents, ROOT_TO_DOCUMENT);
        $allfiles['documents'][] = ROOT_TO_DOCUMENT;
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
            switch($_POST['file_to_organize'])
            {
                case 'downloads': AllFilesStatic::test(ROOT_TO_DOWNLOAD);
                $pass_response = $sharedstatics['file_'.$_POST['file_to_organize']];
                $to_organize = unserialize($pass_response);
                
                break;
                case 'documents': AllFilesStatic::test(ROOT_TO_DOCUMENT);
                $pass_response = $sharedstatics['file_'.$_POST['file_to_organize']];
                $to_organize = unserialize($pass_response);

                break;
                case 'desktop': 
                    AllFilesStatic::test(ROOT_TO_DOCUMENT);
                    $pass_response = $sharedstatics['file_'.$_POST['file_to_organize']];
                    $to_pass_document = unserialize($pass_response);
                    foreach($to_pass_document as $file)
                    {
                        rename(ROOT_TO_DESKTOP.$file,ROOT_TO_DOCUMENT.$file);
                    }

                    $to_organize = $this->binder->getFiles(ROOT_TO_DOCUMENT);
                    break;
                default:throw new Exception("aucun fichier ".$_POST['file_to_organize']."n'est autorisé");break;
            }

            $this->binder->createFile();
            foreach ($to_organize as $files) 
            {
                if (Type::typefile($files) != Type::Use_Docs OR Type::typefile($files) != Type::MacsSpecialFile ) {
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
            if($case !== Type::MacsSpecialFile)
            {
                $types_of_files = Type::stringcases($case);
                $test['type'] = $types_of_files;
                $test['file'] = $file;
                if ($case != Type::Use_Docs) {
                    $test['sub_file'] = [];
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
        }
        if(!isset($other))
            {
                $other[] = null;
            }
            return $other;
    }
}
