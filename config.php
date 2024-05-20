<?php
//---------------"root-files"------------------------------------------
define('USERS','/Users/');
$imageBinder = new Binder();
$root = $imageBinder->getFiles(USERS);
define('PATH_TO_DOWNLOAD',USERS.$root[4].'/'.'Downloads'.'/');
//---------------primary-files-----------------------------------------
define('IMAGE','image');
define('PATH_TO_IMAGE',PATH_TO_DOWNLOAD.IMAGE);
define('CODING','coding');
define('PATH_TO_CODING',PATH_TO_DOWNLOAD.CODING);
define('OBJ_FILES','object');
define('PATH_TO_OBJ_FILES',PATH_TO_DOWNLOAD.OBJ_FILES);
define('CALC_FILES','calcul');
define('PATH_TO_CALC_FILES',PATH_TO_DOWNLOAD.CALC_FILES);
define('DOCS','docs');
define('PATH_TO_DOCS',PATH_TO_DOWNLOAD.DOCS);
define('FILES_AUDIO_VIDEO','audio_video');
define('PATH_TO_AUDIO_VIDEO',PATH_TO_DOWNLOAD.FILES_AUDIO_VIDEO);
define('FILES_UNIDENTIFIED','non_idetentifier');
define('PATH_TO_UNIDENTIFIED',PATH_TO_DOWNLOAD.FILES_UNIDENTIFIED);
define('FILES_RAND','files');
define('PATH_TO_FILES',PATH_TO_DOWNLOAD.FILES_RAND);
// ----------------------sub-files----------------------------------------
define('SUB_FILE_PHP','coding_php');
define('SUB_PATH_TO_PHP',PATH_TO_CODING.'/'.SUB_FILE_PHP);
define('SUB_FILE_PYTHON','coding_python');
define('SUB_PATH_TO_PYTHON',PATH_TO_CODING.'/'.SUB_FILE_PYTHON);
define('SUB_FILE_JAVASCRIPT','coding_javascript');
define('SUB_PATH_TO_JAVASCRIPT',PATH_TO_CODING.'/'.SUB_FILE_JAVASCRIPT);
define('SUB_FILE_HTML','coding_html');
define('SUB_PATH_TO_HTML',PATH_TO_CODING.'/'.SUB_FILE_HTML);
define('SUB_FILE_CSS','coding_css');
define('SUB_PATH_TO_CSS',PATH_TO_CODING.'/'.SUB_FILE_CSS);
define('SUB_FILE_CPP','coding_cpp');
define('SUB_PATH_TO_CPP',PATH_TO_CODING.'/'.SUB_FILE_CPP);
define('SUB_FILE_C','coding_c');
define('SUB_PATH_TO_C',PATH_TO_CODING.'/'.SUB_FILE_C);
define('SUB_FILE_ANGULAR','coding_angular');
define('SUB_PATH_TO_ANGULAR',PATH_TO_CODING.'/'.SUB_FILE_ANGULAR);
define('SUB_FILE_SYMFONY','coding_symfony');
define('SUB_PATH_TO_SYMFONY',PATH_TO_CODING.'/'.SUB_FILE_SYMFONY);

class AllFilesStatic 
{
    public function __construct() {
        $this->definer();
    }

    public static function definer()
    {
        $consts = get_defined_constants(true)['user'];
        foreach($consts as $key => $const)
        {
            
            switch($key)
            {
                case str_contains($key,'USERS') OR str_contains($key,'PATH_TO_DOWNLOAD'): break; 
                case str_contains($key,'SUB_PATH') :$allconst['sub_paths'][] =  $const; break;
                case str_contains($key,'PATH') :$allconst['paths'][] =  $const; break;
                case str_contains($key,'SUB_FILE') :$allconst['sub_files'][] =  $const; break;
                default :$allconst['files'][] =  $const; break;
            } 
        }
        return $consts = $allconst;
    }
}
