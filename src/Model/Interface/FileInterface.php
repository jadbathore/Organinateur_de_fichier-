<?php

namespace App\Model\Interface;

use App\Model\Enum\File;

interface FileInterface {
    public function getFileName():string;
    public function getFileType():File;
    public function fileInfo():string|bool;
    public function findAccordingPath():string; 
}