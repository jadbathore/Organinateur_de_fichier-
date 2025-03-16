<?php

namespace App\Controller;

use App\model\Attributes\CommunFunction;
use App\model\Attributes\Route;
use App\model\Attributes\RequestMethod;
use App\model\Enum\Type;
use App\model\Enum\User;
use App\model\Abstract\AbstractImplementor;


#[Route('/user')]
class UsersController extends AbstractImplementor
{

    #[Route(''),RequestMethod('GET'),CommunFunction('user')]
    public function user()
    {
        $users = $this->binder->getFiles(ROOT_USERS);
        $file['users'][] = $this->display_in_file($users,ROOT_USERS);
        $file['users'][] = ROOT_USERS;
        static $users = serialize($users);
        return $this->twigObject->render('user/index.html.twig', [
            'content_downloads' => $file,
        ]);
    }

    #[Route(''),RequestMethod('POST'),CommunFunction('user')]
    public function userPost(...$sharedstatics)
    {
        $to_bind = \unserialize($sharedstatics['users']);
        foreach($to_bind as $userfile)
        {
            $typeUser = User::typefile($userfile);
            if($typeUser == User::Other)
            {
                rename(ROOT_USERS.$userfile,ROOT_TO_DOCUMENT.$userfile);
            }
        }
    }

    public function display_in_file($array, $directory): array
    {
        foreach ($array as $file) {
            if($file)
            $case = Type::typefile($file);
            $userCase = User::typefile($file);
            if(($userCase !=  User::CoddingApp) and ($userCase != User::ToNotDisplay))
            {
                $types_of_files = User::nameSelected($userCase);
                $test['type'] = $types_of_files;
                $test['file'] = $file;
                $test['sub_file'] = [];
                if ($case == Type::Files) {
                    $sub_files = $this->binder->getFiles($directory . $file);
                    foreach($sub_files as $sub)
                    {
                        $casefile = Type::typefile($sub);
                        if($casefile != Type::MacsSpecialFile)
                        {
                            $test['sub_file'][] = $sub;
                        } 
                    } 
                    if(empty($test['sub_file']))
                    {
                        $test['sub_file'] = null;
                    }
                } else {
                    unset($test['sub_file']);
                }
                $test['root'] = $directory . $file;
                $other[] = $test;
            }
        }
        return $other;
    }
}