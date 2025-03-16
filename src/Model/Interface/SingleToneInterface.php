<?php

namespace App\Model\Interface;

interface SingleToneInterface {
    public function __wakeup();
    public static function instance():self;
}