<?php

namespace Controller;

use model\Attributes\CommunFunction;
use model\Attributes\Route;
use model\Attributes\RequestMethod;
use model\enum\Type;
use model\enum\User;
use model\Twig\AbstractImplementor;

use function main\display;

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
        $to_bind = unserialize($sharedstatics['users']);
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
            $case = Type::typefile($file);
            $types_of_files = Type::stringcases($case);
            $test['type'] = $types_of_files;
            $test['file'] = $file;
            if ($case != Type::Use_Docs) {
                if ($case == Type::Files) {
                    $sub_files = $this->binder->getFiles($directory . $file);
                    $test['sub_file'] = $sub_files;
                } else {
                    unset($test['sub_file']);
                }
            } else {
                unset($test['sub_file']);
            }
            $test['root'] = $directory . $file;
            $other[] = $test;
        }
        return $other;
    }
}