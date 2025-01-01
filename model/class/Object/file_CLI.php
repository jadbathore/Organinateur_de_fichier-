<?php

namespace model\class\Object;

use EmptyIterator;
use model\enum\File;
use model\interface\FileInterface;
use \finfo;
use model\class\singleTone\FileOpener;

class File_CLI implements FileInterface {

    private File $typeFile;
    private FileOpener $FileOpenerInstance;
    private string|bool $infoFile;

    public function __construct(private string $fileName)
    {
        $this->setInfoFile();
        $this->setFileType();
        $this->FileOpenerInstance = FileOpener::instance();
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

    public function subPath_Correction():void
    {
        if($this->typeFile == File::Files)
        {
            $internalTypeArray = [];
            foreach($this->FileOpenerInstance->getFiles($this->fileName) as $subfile)
            {
                $subInternalClass = new File_CLI($this->fileName.'/'.$subfile);
                if(File::sutableFileCase($subInternalClass->getFileType()))
                {
                    $stringCase = File::select($subInternalClass->getFileType());
                    $internalTypeArray[$stringCase] = 
                    (!isset($internalTypeArray[$stringCase]))?0:
                    $internalTypeArray[$stringCase]+1;
                }
            }
            $max =(empty($internalTypeArray))? null :array_search(max($internalTypeArray),$internalTypeArray);
            $CorrectionType = File::from($max ?? 'empty file');
            switch($CorrectionType)
            {
                case File::Files: break;
                default:
                    $this->typeFile = $CorrectionType;
                break;
            }
        }
    }

    public function findAccordingPath():string
    {
        $explodeFile = explode('/',$this->fileName);
        $replacement = array_replace_recursive($explodeFile,array(count($explodeFile) - 1 =>File::select($this->typeFile)));
        $replacement[] = $explodeFile[count($explodeFile) - 1];
        return implode("/",$replacement);
    }
} 