<?php

namespace Controller;

use Directory;
use model\Route;
use model\Twig\TwigImplementor;
use model\enum\Image;
use model\enum\Type;
use model\Binder;
use model\displaying;


#[Route('/imagecompressor')]
class ImageController extends TwigImplementor
{

    #[Route('')]
    public function index(){   
    $binder = new Binder();
    $imagefile = $binder->getFiles(ROOT_TO_DOWNLOAD.'image');
    $dirImage = $this->display_in_file($imagefile);
    // displaying::display($dirImage);
// return $this->twigObject->render('image/index.html.twig');
    }

    public function display_in_file($arrayDirectory):array {
        foreach($arrayDirectory as $directory)
        {
            $type = Type::typefile($directory);
            $type_files =  Type::forSelect($type)['files'];
            $toDisplay['type'] = $type_files;
            $toDisplay['name'] = $directory;
            $toDisplay['size'] = filesize($directory);
            $image = Image::ImageType($directory,$type);
            if($image != Image::Error)
            {
                $nameImage = Image::nameSelected($image);
                $toDisplay['image_type'] = $nameImage;
            } else {
                $nameImage = Image::nameSelected($image,$type);
                $toDisplay['image_type'] = $nameImage;
            }
        }
        return $toDisplay;
    }
}