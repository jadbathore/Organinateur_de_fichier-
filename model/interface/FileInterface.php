<?php

namespace model\interface;

use model\enum\File;

interface FileInterface {
    public function getFileName():string;
    public function getFileType():File;
    public function fileInfo():string|bool;
    public function findAccordingPath():string; 
}