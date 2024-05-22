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
        $sub_case = SubType::typesubfile($filesname,$typeFiles);
        if($sub_case != SubType::Unidentified)
        {
            $path_of_sub_case = SubType::ForSelect_sub($sub_case,$typeFiles)['path'];
            return rename(PATH_TO_DOWNLOAD.$filesname,$path_of_sub_case.'/'.$filesname);
        }
    }
}

public function createFile()
{
    $allfiles_to_create = array_merge(
    AllFilesStatic::definer()['paths'],
    AllFilesStatic::definer()['sub_paths']
    );

    foreach($allfiles_to_create as $path)
    {
        if(!is_dir($path))
        {
            mkdir($path,0777);
        } 
    }
}
}

