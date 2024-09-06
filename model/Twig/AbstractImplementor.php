<?php
namespace model\Twig;

use Exception;

abstract class AbstractImplementor
{
    public function __construct(
        public ?object $twigObject = null,
        public ?object $binder = null,
        ) {
        $loader = new \Twig\Loader\FilesystemLoader('../viewer/');
        $this->twigObject = new \Twig\Environment($loader);
        $this->binder = new \model\Binder;
        $binder = $this->binder;
        global $binder;
    }
    public function flashMessage(string $message,string $option):string
    {
        switch($option)
        {
            case 'success': return '<p class=" bg-success m-auto p-2 text-white text-center w-50 m-auto">'.$message.'<p>';break;
            case 'error': return '<p class="bg-danger m-auto p-2 text-white text-center w-50 m-auto">'.$message.'<p>';break;
            case 'errorExcep': throw new Exception($message);break;
            default:return '<p class="'.$option.'">'.$message.'<p>';
            
        }
    }
} 

