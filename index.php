<?php
//Main presentation file. Acts as a controller for the rest of the files

require 'includes/mustache/Mustache.php';



class Presentation {
    
    
}

/** Controller class
 * 
 */
class Controller {
    public $template = 'code_layout';
    public $data = array();
    public $title = 'index';
    
    
    
    function route() {
        $R = new Renderer();
        
        if ( $_GET['url'] ) {
            //if function exists in route - call it
        } else {
            $this->index();
        }

        
        $this->beforeRender();
        $R->render( $this->template, $this->data, $this->title );
    }
    
    function index() {

    }
    
    
    //set variables etc.
    function beforeRender(){
        
    }
}

//Static class for rendering presentation views
class Renderer {
    //Contains an array of all the templates we are using
    public $templates = array();
    public $template_data = array( 'content' => array() );
    
    function render( $template, $data, $title = 'Templates' ) {
        //get all the available templates. Not super efficient, but works in a pinch!
        $this->loadTemplates();
        
        $M = new Mustache();
        $this->template_data['title'] = $title;
        
        //Now, render the desired template into a variable
        $this->template_data['content'] = $M->render( $this->templates[ $template ], $data, $this->templates );
        
        //Render the main title
        $main_template = file_get_contents( 'templates/main.mustache' );
        
        echo $M->render( $main_template, $this->template_data, $this->templates );

    }
    
    
    private function loadTemplates(){
        
        if ($handle = opendir('templates')) {

            /* loop through each file. */
            while (false !== ($entry = readdir($handle))) {
                
                //skip non .mustache files
                if( stristr( $entry, '.mustache' ) === false ) {
                    continue;
                    
                }
                
                //Template name is the filename without the extension
                $template_name = str_replace('.mustache', '', $entry );
                //if name like .mustache
                $this->templates[$template_name] = file_get_contents( 'templates/' . $entry );
                
                
            }

            closedir($handle);
            
        }
        
        
    }
}

$C = new Controller();
$C->route();