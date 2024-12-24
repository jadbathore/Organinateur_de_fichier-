<?php

namespace model\class\Object;
use model\enum\File;
use model\interface\FileInterface;
use \finfo;

class File_CLI implements FileInterface {

    private File $typeFile;
    private string|bool $infoFile;

    public function __construct(private string $fileName)
    {
        $this->setInfoFile();
        $this->setFileType();
    }

    private function setInfoFile():void
    {
        $finfo = @new finfo(FILEINFO_MIME);
        $info = finfo_file($finfo, $this->fileName);
        $test = (current(explode(';',$info)) == false)? $info: current(explode(';',$info));
        $this->infoFile = $test;
        finfo_close($finfo);
    }

    private function setFileType():void
    {
        $this->typeFile = File::sorting_a_type($this->fileName,$this->infoFile);
    }
    
    public function getFileName():string
    {
        return $this->fileName;
    }

    public function getFileType():File
    { 
        return $this->typeFile;
    }


    public function fileInfo():string|bool
    {
        return $this->infoFile;
    }

    public function findAccordingPath():string
    {
        $explodeFile = explode('/',$this->fileName);
        $replacement = array_replace_recursive($explodeFile,array(count($explodeFile) - 1 =>File::select($this->typeFile)));
        $replacement[] = $explodeFile[count($explodeFile) - 1];
        return implode("/",$replacement);
    }

    // public 
} 