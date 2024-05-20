<?php
class Binder
{
public function getFiles($directory)
{
    $i = 0;
    if ($handle = opendir($directory)) {
        $images = [];
        while (false !== ($entry = readdir($handle))) {
            if ($entry != '.' and $entry != '..')
                $images[$i] = $entry;
            $i++;
        }
        closedir($handle);
        return $images;
    }
}
public function slicesFiles(Type $typeFiles,$filesname)
{
    
    $path_of_case = Type::forSelect($typeFiles)['path'];
    return rename(PATH_TO_DOWNLOAD.$filesname,$path_of_case.'/'.$filesname);
    // return match($typeFiles)
    // {
    // ($typeFiles == Type::Docs)      => rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_DOCS.'/'.$filesname),
    // ($typeFiles == Type::Coding)    => rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_CODING.'/'.$filesname),
    // ($typeFiles == Type::Calc)      => rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_CALC_FILES.'/'.$filesname),
    // ($typeFiles == Type::Image)     => rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_IMAGE.'/'.$filesname),
    // ($typeFiles == Type::Audio_Video)=> rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_AUDIO_VIDEO.'/'.$filesname),
    // ($typeFiles == Type::Files)     => rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_FILES.'/'.$filesname),
    // ($typeFiles == Type::Unidentified)=> rename(PATH_TO_DOWNLOAD.$filesname,PATH_TO_FILES.'/'.$filesname),
    // ($typeFiles == Type::Error)     =>  'erreur',
    // default => 'default',
    // };

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

