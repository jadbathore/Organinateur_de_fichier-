<?php

namespace model;

use model\Twig\AbstractImplementor;
use Twig\Node\Expression\FunctionExpression;

class MajorErrorHandler extends AbstractImplementor
{
    public static function errorHandler():callable
    {
        return function (){
            $error = error_get_last();
            if($error === null){
                return;
            };
            $e =  new \ErrorException(
                message:$error['message'],
                code:1,
                filename:$error['file'],
                line:$error['line']);
                ;
                $message_title = explode(' ',$e->getMessage());
                $sliced = array_slice($message_title,0,6);
                $mess = implode(' ',$sliced);
                $loader = new \Twig\Loader\FilesystemLoader('viewer');
                $twig = new \Twig\Environment($loader);
                echo $twig->render('error/errorCode.html.twig',[
                'message_error' => $mess,
                'file'=>$e->getFile(),
                'severity'=>$e->getSeverity(),
                'error'=> $e->getMessage(),
                'line'=>$e->getLine()
            ]);
        };
    }
}