<?php
//---------------"root-files"------------------------------------------
define('USERS','/Users/');
$imageBinder = new Binder();
$root = $imageBinder->getFiles(USERS);
define('ROOT_TO_DOWNLOAD',USERS.$root[4].'/'.'Downloads'.'/');
define('ROOT_TO_DESKTOP',USERS.$root[4].'/'.'Desktop'.'/');
define('ROOT_TO_DOCUMENT',USERS.$root[4].'/'.'Documents'.'/');
//---------------primary-files-----------------------------------------
define('IMAGE','image');
define('PATH_TO_IMAGE',ROOT_TO_DOWNLOAD.IMAGE);
define('CODING','coding');
define('PATH_TO_CODING',ROOT_TO_DOWNLOAD.CODING);
define('OBJ_FILES','object');
define('PATH_TO_OBJ_FILES',ROOT_TO_DOWNLOAD.OBJ_FILES);
define('CALC_FILES','calcul');
define('PATH_TO_CALC_FILES',ROOT_TO_DOWNLOAD.CALC_FILES);
define('DOCS','docs');
define('PATH_TO_DOCS',ROOT_TO_DOWNLOAD.DOCS);
define('FILES_AUDIO_VIDEO','audio_video');
define('PATH_TO_AUDIO_VIDEO',ROOT_TO_DOWNLOAD.FILES_AUDIO_VIDEO);
define('FILES_UNIDENTIFIED','non_idetentifier');
define('PATH_TO_UNIDENTIFIED',ROOT_TO_DOWNLOAD.FILES_UNIDENTIFIED);
define('FILES_RAND','files');
define('PATH_TO_FILES',ROOT_TO_DOWNLOAD.FILES_RAND);
// ----------------------sub-files----------------------------------------
define('SUB_FILE_PHP','coding_php');
define('SUB_PATH_TO_PHP',PATH_TO_CODING.'/'.SUB_FILE_PHP);
define('SUB_FILE_PYTHON','coding_python');
define('SUB_PATH_TO_PYTHON',PATH_TO_CODING.'/'.SUB_FILE_PYTHON);
define('SUB_FILE_JAVASCRIPT','coding_javascript');
define('SUB_PATH_TO_JAVASCRIPT',PATH_TO_CODING.'/'.SUB_FILE_JAVASCRIPT);
define('SUB_FILE_HTML_CSS','coding_html_css');
define('SUB_PATH_TO_HTML_CSS',PATH_TO_CODING.'/'.SUB_FILE_HTML_CSS);
define('SUB_FILE_CPP','coding_cpp');
define('SUB_PATH_TO_CPP',PATH_TO_CODING.'/'.SUB_FILE_CPP);
define('SUB_FILE_C','coding_c');
define('SUB_PATH_TO_C',PATH_TO_CODING.'/'.SUB_FILE_C);
define('SUB_FILE_SWIFT','coding_swift');
define('SUB_PATH_TO_SWIFT',PATH_TO_CODING.'/'.SUB_FILE_SWIFT);
define('SUB_FILE_ANGULAR','coding_angular');
define('SUB_PATH_TO_ANGULAR',PATH_TO_CODING.'/'.SUB_FILE_ANGULAR);

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
                case str_contains($key,'USERS'): break; 
                case str_contains($key,'ROOT'):$allconst['roots'][] = $const;break;
                case str_contains($key,'SUB_PATH') :$allconst['sub_paths'][] =  $const; break;
                case str_contains($key,'PATH') :$allconst['paths'][] =  $const; break;
                case str_contains($key,'SUB_FILE') :$allconst['sub_files'][] =  $const; break;
                default :$allconst['files'][] =  $const; break;
            } 
        }
        return $consts = $allconst;
    }
}
