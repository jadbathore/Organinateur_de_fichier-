<?php

namespace App\Model\Class\SingleTone;

use App\Model\Class\Object\file_CLI;
use App\Model\Enum\File;
use App\Model\Interface\SingleToneInterface;

class Organisator extends FileOpener implements SingleToneInterface {
    private array $fileOrganizeName;
    private ?array $definedRootPropreties = null;
    private static ?Organisator $instance;

    protected function __construct(
        private ?string $dir = null 
    ) {
        $this->setFileOrganizeName();
        $this->setDir($dir) ?? $this->definedRootPropreties = get_defined_constants(true)['user'];
    }
    
    protected function __clone()
    {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function &instance(... $args):Organisator
    {   
        {
            if(!isset(self::$instance))
            {
                self::_init_();
            }
            return self::$instance;
        }
    }

    public static function _init_(?string $dir = null)
    {
        self::$instance =  new static($dir);
    }

    private function setFileOrganizeName()
    {
        foreach(File::cases() as $case)
        {
            if(File::sutableFileCase($case) && $case != File::Package)
            {
                $this->fileOrganizeName[] = $case->value;
            }
        }
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
    
    public function bind_and_organiseFile()
    {
        $this->createFile();
        foreach($this->definedRootPropreties ?? [$this->dir] as $root)
        {
            $arrayFile = $this->getFiles($root);
            foreach($arrayFile ?? [] as $file)
            {
                $file_Class = new file_CLI($root.$file);
                    if(File::sutableFileCase($file_Class->getFileType()))
                    {
                        if($root == ROOT_TO_DESKTOP)
                        {       
                            $transferPath = ROOT_TO_DOCUMENT.$file;
                            rename($file_Class->getFileName(),$transferPath);
                        } else {
                            if($file_Class->getFileType() == File::Files)
                            {
                                $file_Class->subPath_Correction();
                            }
                            $file_Class->handlePath();
                        }
                    }
            }
        }
    } 

    private function createFile()
    {
        foreach($this->definedRootPropreties ?? [$this->dir] as $root)
        {
            if($root != ROOT_TO_DESKTOP)
            {
                foreach ($this->fileOrganizeName as $namePath) {
                    $namedir = $root . $namePath;
                    if (!is_dir($namedir)) {
                        mkdir($namedir, 0777);
                    }
                }
            }
        }
    }
}