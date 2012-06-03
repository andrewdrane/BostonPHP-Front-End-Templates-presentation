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
    
    //setup the renderer
    function __construct(){
        $this->R = new Renderer();
    }
    
    function route() {
        
        if ( $_GET['url'] ) {
            //if function exists in route - call it
            call_user_func( array( $this, $_GET['url'] ) );
        } else {
            $this->index();
        }

        
        $this->beforeRender();
        $this->R->render( $this->template, $this->data, $this->title );
    }
    
    function index() {

    }
    
    
    function code_basic() {
        $this->data['title'] = 'Basic rendering';
        $this->data['template_code'] = $this->getEscapedTemplate('basic');
        $this->data['data'] = json_encode( array(
            'first_name' => 'Andrew',
            'last_name' => 'Drane'
        ) );
    }
    
    function code_lists() {
    }
    
    function code_sub_template() {
    }

    function code_repeating() {
    }


    
    //set variables etc.
    private function beforeRender(){
//          array('url' => '', 'title' => ''),  
        $this->R->template_data['links'] = array(
          array('url' => '', 'title' => 'Home'),  
          array('url' => 'code_basic', 'title' => 'Basic'),  
          array('url' => 'code_lists', 'title' => 'Lists'),  
          array('url' => 'code_sub_template', 'title' => 'Sub Template'),  
          array('url' => 'code_repeating', 'title' => 'repeating'),  
        );
        
    }
    
    //get any template that's been loaded
    private function getTemplate( $template_name ){
        if( isset( $this->R->templates[ $template_name ] ) ) {
            return $this->R->templates[ $template_name ];
        } else {
            return null;
        }
    }
    
    //Escapes quotes and more from the templates.
    private function getEscapedTemplate( $template_name ){
        return str_replace( 
                array("\n", '"', "'"), 
                array("\\n\\\n", '\"', "\'"), 
                $this->getTemplate( $template_name ) 
                );
    }
}

//Static class for rendering presentation views
class Renderer {
    //Contains an array of all the templates we are using
    public $templates = array();
    public $template_data = array( 'content' => array() );
    
    
    function __construct(){
        //get all the available templates. Not super efficient, but works in a pinch!
        $this->loadTemplates();
    }
    
    function render( $template, $data, $title = 'Templates' ) {
        
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