<?php

namespace Controller;

use Exception;
use model\enum\Image;
use model\enum\Type;
use main\AllFilesStatic;
use model\Attributes\CommunFunction;
use model\Attributes\RequestMethod;
use model\Attributes\Route;
use model\Twig\AbstractImplementor;

use function main\display;

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
    $imagefile = $this->binder->getFiles(PATH_TO_IMAGE);
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
        foreach($to_resize as $image)
        {
            $path = PATH_TO_IMAGE.'/'.$image;
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

    public function display_in_file($arrayDirectory):array {
        $i = 0;
        foreach($arrayDirectory as $directory)
        {
            $type = Type::typefile($directory);
            $type_files = Type::forSelect($type)['file'];
            $size = filesize(PATH_TO_IMAGE.'/'.$directory);
            $toDisplay[$i]['name'] = $directory;
            $toDisplay[$i]['size'] = $size;
            $image = Image::ImageType(PATH_TO_IMAGE.'/'.$directory,$type);
            if($image != Image::Error)
            {
                $nameImage = Image::nameSelected($image);
                $toDisplay[$i]['image_type'] = $nameImage;
            } else {
                $nameImage = Image::nameSelected($image,$type);
                $toDisplay[$i]['image_type'] = $nameImage;
            }
            $i++;
        }
        return $toDisplay;
    }

    public function total_size_dir($arrayDirectory): int {
        $total = 0;
        foreach($arrayDirectory as $directory)
        {
            $size = filesize(PATH_TO_IMAGE.'/'.$directory);
            $total += $size; 
        }
        return $total;
    }
}