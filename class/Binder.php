<?php
class Binder
{
public function getFiles($directory)
{
    $i = 0;
    if ($handle = opendir($directory)) {
        $docs = [];
        while (false !== ($entry = readdir($handle))) {
            if ($entry != '.' and $entry != '..')
                $docs[$i] = $entry;
            $i++;
        }
        closedir($handle);
        return $docs;
    }
}
public function slicesFiles(Type $typeFiles,$filesname)
{
    if($typeFiles != Type::Files)
    {
        $path_of_case = Type::forSelect($typeFiles)['path'];
        return rename(PATH_TO_DOWNLOAD.$filesname,$path_of_case.'/'.$filesname);
    } else {
        $content_of_random_files = $this->getFiles(PATH_TO_DOWNLOAD.$filesname);
        foreach($content_of_random_files as $sub_files)
        {
            ;
        }
    }
    
}

public function createFile()
{
    foreach(AllFilesStatic::definer()['paths'] as $path)
    {
        if(!is_dir($path))
        {
            mkdir($path,0777);
        } 
    }
}
}

