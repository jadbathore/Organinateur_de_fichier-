<?php

use function main\display;
use model\enum\Type;

require_once '../vendor/autoload.php';
require_once 'ModelAutoloader.php';
require 'config.php';

display(Type::stringcases(Type::Unidentified));
