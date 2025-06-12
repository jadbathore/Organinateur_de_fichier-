<?php

namespace App\Model\Class\SingleTone;

use Error;
use App\Model\Interface\FileInterface;
use App\Model\Interface\SingleToneInterface;

class FileOpener {

    private static ?FileOpener $instance;

    private function __construct()
    {}
    
    private function __clone()
    {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public function init(mixed ...$args): void{
        self::$instance =  new static(... $args);
    }


    public static function &instance(mixed ...$args):self
    {   
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
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
                throw new Error("directory Can't be open :".$directory.'"');
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