<?php 
/*------------------------------------------------------------
| LOADER CLASS CONFIGURATION
--------------------------------------------------------------
| DO NOT REMOVE THIS CONFIGURATION UNLESS YOU KNOW WHAT TO DO
| THIS IS DEFAULT STRUCTURE FOR THE CONFIGURATION
| ONLY EDIT ON PART OF THE VALUE
|------------------------------------------------------------*/

class Loader
{

    /*
        GLOBAL VARIABLE
    */

	protected $cssScript;
	protected $jsScript;

    /*
        LOADER FOR VIEWS
    */

	public function view($path)
	{
        $controller = explode("/", $path);
		$class = end($controller) . 'Controller';
		$controller = new $class();
		include_once(CURR_VIEW_DIR . "{$path}.php");
	}

    /*
        LOADER FOR CSS AND JS
    */

	public function publicPush($folder=NULL,$sub=NULL){
        
        if ($folder !== NULL && $sub == NULL) {
            $this->publicLoader($folder);
        }elseif ($folder !== NULL && $sub !== NULL){
            $this->publicLoader($folder,$sub);
        }
    }

    private function publicLoader($folder,$sub=NULL){
        //Grab all data from public direcrory and listing
        $script = '';
        
        foreach(array_values(glob('public/'.$folder.'/'.$sub.'/*.*')) as $filename){
            if ($folder == 'css' || $folder == 'fonts') {
                $script .= '<link rel="stylesheet" href="'.PERMALINK.$filename.'">'.PHP_EOL;
            }elseif($folder == 'js'){
            	$script .= '<script src="'.PERMALINK.$filename.'"></script>'.PHP_EOL;
            }
        }

        echo $script;
    }

    public function publicLoaderFonts($fontname){
        echo '<link rel="stylesheet" href="//fonts.googleapis.com/css?family='.$fontname.'">'.PHP_EOL;
    }
}