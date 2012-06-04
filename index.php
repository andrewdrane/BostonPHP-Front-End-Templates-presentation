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
        $this->template = 'title_slide';
        $this->data['headline'] = 'Client Side Templates';
        $this->data['subhead'] = 'Free your views to be rendered anywhere';
        
        
        $this->data['extra'] = array();
        $this->data['extra'][] = 'Featuring Mustache: <a href="http://mustache.github.com/">http://mustache.github.com/</a>';
        $this->data['extra'][] = 'Presentation code on GitHub: <a href="https://github.com/andrewdrane/BostonPHP-Front-End-Templates-presentation">https://github.com/andrewdrane/BostonPHP-Front-End-Templates-presentation</a>';
        $this->data['extra'][] = 'Slides online: <a href="http://adrane.com">http://adrane.com</a>';
          
    }
    
    
    function resources() {
        $this->template = 'title_slide';
        $this->data['headline'] = 'Additional Resources';
        $this->data['subhead'] = 'Ke';
        
        
        $this->data['extra'] = array();
        $this->data['extra'][] = 'Mustache, with links to various language libraries: <a href="http://mustache.github.com/">http://mustache.github.com/</a>';
        $this->data['extra'][] = 'Backbone JS: <a href="http://backbonejs.org/">http://backbonejs.org/</a>';
        $this->data['extra'][] = 'Mustache, with links to various language libraries: <a href="http://mustache.github.com/">http://mustache.github.com/</a>';
        $this->data['extra'][] = 'Mustache, with links to various language libraries: <a href="http://mustache.github.com/">http://mustache.github.com/</a>';
        $this->data['extra'][] = 'Mustache, with links to various language libraries: <a href="http://mustache.github.com/">http://mustache.github.com/</a>';
          
    }
    
    
    function code_basic() {
        $this->data['headline'] = 'Basic rendering';
        $this->data['subhead'] = 'Mapping data to a template';

                
        $this->data['template_code'] = $this->getEscapedTemplate('basic');
        $this->data['template_display_code'] = $this->getTemplate('basic');
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
        $links = array(
          array('url' => '', 'title' => 'Home'),  
          array('url' => 'code_basic', 'title' => 'Basic'),  
          array('url' => 'code_lists', 'title' => 'Lists'),  
          array('url' => 'code_sub_template', 'title' => 'Sub Template'),  
          array('url' => 'code_repeating', 'title' => 'repeating'),  
        );
        
        $this->R->template_data['links'] = $links;
        

        //next and previous links
        $this->R->template_data['nav'] = array();
        
        foreach ($links as $key => $link ) {
        
            if ( $link['url'] == $_GET['url'] ) {
                if( isset( $links[ $key+1 ] ) ) {
                    $this->R->template_data['nav']['next'] = $links[ $key+1 ]['url'];
                }
                
                if( isset( $links[ $key-1 ] ) ) {
                    $this->R->template_data['nav']['prev'] = $links[ $key-1 ]['url'];
                }
                
                break;
            }

        }


        
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
        
        //Detect AJAX requests. Send just data if an ajax request!
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['template']['name'] = $template;
            $data['template']['title'] = $title;
            $data['template']['nav'] = $this->template_data['nav']; //Send the next and previous data, in case we need it
            echo json_encode( $data );
        } else {
            //Render the desired template into a variable
            $this->template_data['content'] = $M->render( $this->templates[ $template ], $data, $this->templates );
            
             //Render the main title
            $main_template = file_get_contents( 'templates/main.mustache' );

            echo $M->render( $main_template, $this->template_data, $this->templates );
        }
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