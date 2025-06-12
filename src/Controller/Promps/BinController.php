<?php
namespace App\Controller\Promps;

use Error;
use App\Model\Abstract\AbstractPrompsController;
use App\Model\Attributes\Promps\Command;
use App\Model\Attributes\Promps\Description;
use App\Model\Attributes\Promps\Option;

class BinController extends AbstractPrompsController
{
    #[
        
        Command('organise'),
        Option(
            [
                '-dir'=>'<directive>'
            ]),
        Description(
            "organise the file to between download/desktop/documents directory".
            "\nchoose witch one you want with the [-dir] option")
    ]
    public function organise(null|string|bool $dir){
        switch(gettype($dir))
        {
            case "string":
                $this->setOrganisator('testdir');
            break;
            case "boolean":
                throw new Error(
                $this->color("you must prompt one of those dir witch are:\n","red","underline").
                $this->color("-downloads\n-desktop\n-documents\n","red"));
            break;
        }
        $this->getOrganisator()
        ->bind_and_organiseFile();
    }

    #[
        /* Commande utilisée pour activer la méthode.  */
        Command('test'),
        /* Option utilisable avec la commande  */
        Option(
            [
                '-test'=>'<dtest>',
                '-b'=>true
            ])
        /* La description de ce que fait la commande. */
        ,Description('Test function')
    ]
    public function test(
        null|string|bool $dtest,
        null|bool $b
        ){
        var_dump($dtest,$b);
    }

    #[
        Command('debug'),
        Description("Special method return this when the command"
        ."\nis not in system or no input has been prompts")
    ]
    public function debug(callable $script)
    {
        $this->color("\nCLI_File_Organisator:\n","green","bold","underline");
        $script();
    }
}