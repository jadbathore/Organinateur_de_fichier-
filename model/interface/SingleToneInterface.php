<?php

namespace model\interface;

interface SingleToneInterface {
    public function __wakeup();
    public static function instance():self;
}