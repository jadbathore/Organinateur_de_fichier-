<?php
namespace App\Model\Abstract;

use Exception;
use App\Model\Class\Binder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Extra\CssInliner\CssInlinerExtension;

abstract class AbstractImplementor
{

    public Environment $twigObject;
    public Binder $binder;
    private string $secretkey;

    public function __construct(
        ) {
        $loader = new FilesystemLoader('../src/viewer/');
        $this->twigObject = new Environment($loader);
        $this->binder = new Binder();

        $this->addTwigFunction();
        $this->addTwigExtension();
        $this->generateSecretkey();
    }

    private function generateSecretkey(){
        $this->secretkey = sodium_crypto_box_keypair();
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

    private function addTwigExtension(){
        $this->twigObject->addExtension(new CssInlinerExtension());
    }

    private function addTwigFunction(){
        $this->twigObject->addFilter(new TwigFilter("decryptFileName",function($encrytedFileName){
            return $this->decryptFileName($encrytedFileName);
        }));
    }

    private function decryptFileName($fileName){
        return openssl_decrypt($fileName,"AES-128-ECB",$this->secretkey);
    }

    public function encryptFileName($fileName){
        return openssl_encrypt($fileName,"AES-128-ECB",$this->secretkey);
    }
} 

