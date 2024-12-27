<?php
namespace Controller\Promps;

use Error;
use model\abstract\abstractPrompsController;
use model\Attributes\Promps\Command;
use model\Attributes\Promps\Description;
use model\Attributes\Promps\Option;

class ActionController extends abstractPrompsController
{
    #[Command('organise'),
    Option(['-dir'=>'<directive>']),
    Description(
    "organise the file to between download/desktop/documents directory".
    "\nchoose witch one you want with the [-dir] option"
    )]
    public function organise(null|string|bool $dir){
        switch(gettype($dir))
        {
            case "string":
                $this->setOrganisator('testdir');
            break;
            case "boolean":
                throw new Error(
                $this->getColoring()->color("you must prompt one of those dir witch are:\n","red","underline").
                $this->getColoring()->color("-downloads\n-desktop\n-documents\n","red"));
            break;
        }
        $this->getOrganisator()
        ->bind_and_organiseFile();
    }

    #[Command('test'),Option(['-test'=>'<dtest>','-b'=>true]),Description('Test function')]
    public function test(null|string|bool $dtest,null|bool $b)
    {
        $this->getColoring()
        ->color("bonjour","green","underline","italic");
    }

    #[Command('debug'),
    Description("Special method return this when the command"
    ."\nis not in system or no input has been prompts")]
    public function debug(callable $script)
    { 
        $script("magenta");
    }
}