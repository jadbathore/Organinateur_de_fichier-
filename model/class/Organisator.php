<?php

namespace model\class;

use model\class\Object\File_CLI;
use model\enum\File;

class Organisator {
    private array $fileOrganizeName;
    private ?array $definedRootPropreties = null;
    
    public function __construct(
        private ?string $dir = null 
    ) {
        $this->setFileOrganizeName();
        $this->setDir($dir) ?? $this->definedRootPropreties = get_defined_constants(true)['user'];
    }

    private function setDir(?string $dir):null|string
    {
        if(is_null($dir))
        {
            return $dir;
        } else {
            $expoldeDir = explode('/',__DIR__);
            $slicepath = array_slice($expoldeDir,0,3);
            $slicepath[] = $dir;
            $rootUser = implode('/',$slicepath);
            $this->dir = $rootUser;
            return $this->dir;
        }
    }

    public function testing()
    {
        var_dump($this->dir);
        var_dump($this->definedRootPropreties);
    }

    private function setFileOrganizeName()
    {
        foreach(File::cases() as $case)
        {
            if(File::sutableFileCase($case))
            {
                $this->fileOrganizeName[] = $case->value;
            }
        }
    }

    public function getFiles(string $directory)
    {
        if (is_dir($directory)) {
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
    }

    public function bind_and_organiseFile()
    {
        $this->createFile();
        foreach($this->definedRootPropreties ?? [$this->dir] as $root)
        {
            $arrayFile = $this->getFiles($root);
            foreach($arrayFile ?? [] as $file)
            {
                $file_Class = new File_CLI($root.$file);
                
                    if(File::sutableFileCase($file_Class->getFileType()))
                    {
                        if($root == ROOT_TO_DESKTOP)
                        {       
                            $transferPath = ROOT_TO_DOCUMENT.$file;
                            rename($file_Class->getFileName(),$transferPath);
                        } else {
                            rename($file_Class->getFileName(),$file_Class->findAccordingPath());
                        }
                    }
            }
        }
    }

    private function createFile()
    {
        foreach($this->definedRootPropreties ?? [$this->dir] as $root)
        {
            foreach ($this->fileOrganizeName as $namePath) {
                if($root != ROOT_TO_DESKTOP)
                {
                    $namedir = $root . $namePath;
                    if (!is_dir($namedir)) {
                        mkdir($namedir, 0777);
                    }
                }
            }
        }
    }

}

