<?php

namespace model\class\singleTone;

use Error;
use model\interface\FileInterface;
use model\interface\SingleToneInterface;

class FileOpener implements SingleToneInterface {

    private static ?FileOpener $instance;

    protected function __construct()
    {}
    
    protected function __clone()
    {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function instance():FileOpener
    {   
        {
            if(!isset(self::$instance))
            {
                self::$instance =  new static();
            }
            return self::$instance;
        }
    }

    public function getFiles(string $directory)
    {
        if (is_dir($directory)) {
            if ($handle = opendir($directory)) {
                $docs = [];
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != '.' and $entry != '..')
                        $docs[] = $entry;
                }
                closedir($handle);
                return $docs;
            } else {
                throw new Error("directory Can't be open");
            }
        }
    }

    public function EmptyFile(string $directory)
    {
        foreach($this->getFiles($directory) as $subpath)
        {
            unlink($directory.'/'.$subpath);
        }
    }
}