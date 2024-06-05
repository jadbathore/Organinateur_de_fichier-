<?php
namespace model\Twig;

abstract class TwigImplementor
{
    public function __construct(
        public ?object $twigObject = null) {
        $loader = new \Twig\Loader\FilesystemLoader('../viewer/');
        $this->twigObject = new \Twig\Environment($loader);
    }
} 

