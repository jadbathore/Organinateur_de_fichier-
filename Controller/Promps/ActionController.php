<?php
namespace Controller\Promps;

use Error;
use model\Attributes\Promps\Command;
use model\Attributes\Promps\Option;
use model\enum\Promp;

class ActionController 
{

    #[Command('organise'),Option(['-dir'=>'<directive>'])]
    public function testCli(?array $option){
        var_dump($option['-dir']);
        switch(true)
        {
            case (!isset($option)):throw new Error('the -dir MUST be use');
            case ($option['-dir'] == "FALSE") :throw new Error('the -dir option must specifie a directive to organise');
            default: 
            $type = Promp::type_promp(strtoupper($option['-dir']));
            var_dump($type);
        }
        // $downloads = $this->binder->getFiles(ROOT_TO_DOWNLOAD);
        // $desktop = $this->binder->getFiles(ROOT_TO_DESKTOP);
        // $documents = $this->binder->getFiles(ROOT_TO_DOCUMENT);
        // $allfiles = [];
        // $allfiles['downloads'][] = (new HomeController)->display_in_file($downloads, ROOT_TO_DOWNLOAD);
        // $allfiles['downloads'][] = ROOT_TO_DOWNLOAD;
        // $allfiles['desktop'][] = (new HomeController)->display_in_file($desktop, ROOT_TO_DESKTOP);
        // $allfiles['desktop'][] = ROOT_TO_DESKTOP;
        // $allfiles['documents'][] = (new HomeController)->display_in_file($documents, ROOT_TO_DOCUMENT);
        // $allfiles['documents'][] = ROOT_TO_DOCUMENT;
    }
    #[Command('test'),Option(['-test'=>'<dtest>',"-b"=>true])]
    public function test(?array $option)
    {
        // var_dump($option);
    }
}