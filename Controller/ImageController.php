<?php

namespace Controller;


use model\Twig\TwigImplementor;
use model\enum\Image;
use model\enum\Type;
use model\Binder;
use main\AllFilesStatic;
use model\Attributes\CommunFunction;
use model\Attributes\RequestMethod;
use model\Attributes\Route;
use model\Twig\AbstractImplementor;

use function main\display;

#[Route('/imagecompressor')]
class ImageController extends AbstractImplementor
{
    #[Route(''),RequestMethod('GET')]
    public function image(){   
    AllFilesStatic::test(ROOT_TO_DOWNLOAD);
    $imagefile = $this->binder->getFiles(PATH_TO_IMAGE);
    $dirImage = $this->display_in_file($imagefile);
    $totalSize = $this->total_size_dir($imagefile);
    return $this->twigObject->render('image/index.html.twig',[
        'dirInfo' => $dirImage,
        'totalSize' => $totalSize
    ]);
    }
    #[Route(''),RequestMethod('POST')]
    public function imagePost()
    {
        echo 'test';
    }

    public function display_in_file($arrayDirectory):array {
        $i = 0;
        foreach($arrayDirectory as $directory)
        {
            $type = Type::typefile($directory);
            $type_files =  Type::forSelect($type)['file'];
            $size = filesize(PATH_TO_IMAGE.'/'.$directory);
            $toDisplay[$i]['type'] = $type_files;
            $toDisplay[$i]['name'] = $directory;
            $toDisplay[$i]['size'] = $size;
            $image = Image::ImageType(ROOT_TO_DOWNLOAD.$directory,$type);
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