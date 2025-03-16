<?php
namespace App\Controller;

use Exception;
use App\model\enum\Image;
use App\model\enum\Type;
use Main\AllFilesStatic;
use App\model\Attributes\CommunFunction;
use App\model\Attributes\RequestMethod;
use App\model\Attributes\Route;
use App\model\Abstract\AbstractImplementor;

/* image controller d'afficher puis compresser la taille des images. 
exemple : pour le dossier que download/image la taille total des fichiers était de 79.85mo puis elle 
est passer à 29.48mo en fait la résolution des images ont étés baisser.
*/
#[Route('/imagecompressor')]
class ImageController extends AbstractImplementor
{
    #[Route(''),RequestMethod('GET'),CommunFunction('image')]
    public function image(){   
    AllFilesStatic::test(ROOT_TO_DOWNLOAD);
    $imagefileDownload = $this->binder->getFiles(ROOT_TO_DOWNLOAD.IMAGE);
    $imagefileDocument = $this->binder->getFiles(ROOT_TO_DOCUMENT.IMAGE);
    $imagefile[ROOT_TO_DOCUMENT] = $imagefileDocument;
    $imagefile[ROOT_TO_DOWNLOAD] = $imagefileDownload;
    $dirImage = $this->display_in_file($imagefile);
    $totalSize = $this->total_size_dir($imagefile);
    static $image = serialize($imagefile);
    return $this->twigObject->render('image/index.html.twig',[
        'dirInfo' => $dirImage,
        'totalSize' => $totalSize
    ]);

    }



    #[Route(''),RequestMethod('POST'),CommunFunction('image')]
    public function imagePost(...$sharedstatics)
    {
        $to_resize = unserialize($sharedstatics['image']);
        foreach($to_resize as $key=>$images)
        {
            foreach($images as $image)
            {
                $path = $key.'image/'.$image;
                $type = Type::typefile($path);
                try {
                    $typeImage = Image::ImageType($path,$type);
                    $createdimage = Image::returncreateImage($typeImage,$path);
                    Image::UpdateImage($typeImage,$path,$createdimage);
                } catch (Exception $execption)
                {
                    echo $this->flashMessage($execption->getMessage(),'bg-warning m-auto p-2 text-white text-center w-50 m-auto');
                }
            }
        }

    }

    public function display_in_file($arrayDirectory) {
        $i = 0;
        foreach($arrayDirectory as $dirpath=>$value)
        {
            foreach($value as $directory)
            {
                $type = Type::typefile($directory);
                if($type != Type::MacsSpecialFile)
                {
                    $path = $dirpath.'image/'.$directory;
                    $size = filesize($path);
                    $toDisplay[$i]['name'] = explode('.',$directory)[0];
                    $toDisplay[$i]['size'] = $size;
                    $toDisplay[$i]['path'] = $path;
                    $image = Image::ImageType($path,$type);
                    if($type != Type::MacsSpecialFile)
                    {
                        $nameImage = Image::nameSelected($image);
                        $toDisplay[$i]['image_type'] = $nameImage;
                    } else {
                        $nameImage = Image::nameSelected($image,$type);
                        $toDisplay[$i]['image_type'] = $nameImage;
                    }
            $i++;
                }
            }
            
        }
        return $toDisplay;
    }

    public function total_size_dir($arrayDirectory): int {
        $total = 0;
        foreach($arrayDirectory as $pathdir=>$value)
        {
            foreach($value as $dir)
            {
                $size = filesize($pathdir.'image/'.$dir);
                $total += $size;
            }
        }
        return $total;
    }
}