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
    public $templates = array();
    public $template_data = array( 'content' => array() );
    
    function render( $template, $data, $title = 'Templates' ) {
        //temporary
        $this->templates['code_layout'] = file_get_contents( 'templates/code_layout.mustache' );
        
        
        $M = new Mustache();
        $this->template_data['title'] = $title;
        
        //Now, render the desired template into a variable
        $this->template_data['content'] = $M->render( $this->templates[ $template ], $data, $this->templates );
        
        //Render the main title
        $main_template = file_get_contents( 'templates/main.mustache' );
        
        echo $M->render( $main_template, $this->template_data, $this->templates );

    }
    
    
    private function loadTemplates(){
        //load up all templates in the directory
    }
}

$C = new Controller();
$C->route();