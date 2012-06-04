<?php
//Main presentation file. Acts as a controller for the rest of the files

require 'includes/mustache/Mustache.php';



class Presentation {
    
    
}

/** Controller class
 * 
 */
class Controller {
    public $template = 'title_slide';
    public $data = array();
    public $title = 'index';
    
    //setup the renderer
    function __construct(){
        $this->R = new Renderer();
    }
    
    function route() {
        
        if ( $_GET['url'] && method_exists( $this, $_GET['url'] ) ) {
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
    
    function intro1() {
        $this->template = 'title_slide';
        $this->data['headline'] = 'What is it and why';
        $this->data['subhead'] = 'Logic-less templates that can be rendered on the browser, or the back end';
        
        
        $this->data['extra'] = array();
        $this->data['extra'][] = '&bull; Allows your server to send simple JSON rather than rendered HTML';
        $this->data['extra'][] = '&bull; Cache views in a javascript file';
        $this->data['extra'][] = '&bull; Separating logic from your code is more portable';
    }
    
    
    function resources() {
        $this->template = 'title_slide';
        $this->data['headline'] = 'Additional Resources';
        $this->data['subhead'] = 'Keep it simple';
        
        
        $this->data['extra'] = array();
        $this->data['extra'][] = 'Mustache, with links to various language libraries: <a href="http://mustache.github.com/">http://mustache.github.com/</a>';
        $this->data['extra'][] = 'Backbone JS: <a href="http://backbonejs.org/">http://backbonejs.org/</a>';
        $this->data['extra'][] = 'Google WebFonts: <a href="http://www.google.com/webfonts">http://www.google.com/webfonts</a>';
        $this->data['extra'][] = 'Twitter Bootstrap <a href="http://twitter.github.com/bootstrap/index.html">http://twitter.github.com/bootstrap/index.html</a>';
        $this->data['extra'][] = 'jQuery: <a href="http://jquery.com/">http://jquery.com/</a>';
          
    }
    
    
    function code_basic() {
        $this->template = 'code_layout';
        $this->data['headline'] = 'Basic rendering';
        $this->data['subhead'] = 'Mapping data to a template';

                
        $this->data['template_code'] = $this->getEscapedTemplate('basic');
        $this->data['template_display_code'] = $this->getTemplate('basic');
        $this->data['data'] = json_encode( array(
            'first_name' => 'Andrew',
            'last_name' => 'Drane'
        ) );
    }
    
    //simple re-use
    private function colleagueData(){
        return array(
            'first_name' => 'Andrew',
            'last_name' => 'Drane',
            'colleagues' => array(
                array(
                    'first_name' => 'Michael',
                    'last_name' => 'Bourque',
                    'presenting' => false,
                ),
                array(
                    'first_name' => 'Matt',
                    'last_name' => 'Murphy',
                    'presenting' => true,
                ),
                array(
                    'first_name' => 'Gene',
                    'last_name' => 'Babon',
                    'presenting' => true,
                ),
                array(
                    'first_name' => 'Heather',
                    'last_name' => 'O\'Neill',
                    'presenting' => true,
                ),
                array(
                    'first_name' => 'Devan',
                    'last_name' => 'Calabrez',
                    'presenting' => false,
                )
            )
        );
    }
    
    function code_escaping() {
        $this->template = 'code_layout';
        $this->data['headline'] = 'Escaping';
        $this->data['subhead'] = 'For your protection';

        $this->data['template_code'] = $this->getEscapedTemplate('escaping');
        $this->data['template_display_code'] = $this->getTemplate('escaping');
        $this->data['data'] = json_encode( array('data' => '<u>Mustache</u> is <strong>Awesome</strong>' ) );
    }
    
    function code_lists() {
        $this->template = 'code_layout';
        $this->data['headline'] = 'Rendering a list';
        $this->data['subhead'] = 'and conditionals too!';

        $this->data['template_code'] = $this->getEscapedTemplate('lists');
        $this->data['template_display_code'] = $this->getTemplate('lists');
        $this->data['data'] = json_encode($this->colleagueData() );
    }
    
    function code_partials() {
        $this->template = 'code_layout';
        $this->data['headline'] = 'Using partials';
        $this->data['subhead'] = 'For better code re-use';

        $this->data['template_code'] = $this->getEscapedTemplate('partials');
        $this->data['template_display_code'] = $this->getTemplate('partials') . "\n\n----\n_colleague.mustache\n\n" . $this->getTemplate('_colleague');
        $this->data['data'] = json_encode($this->colleagueData() );
    }
    



    
    //set variables etc.
    private function beforeRender(){
//          array('url' => '', 'title' => ''),  
        $links = array(
          array('url' => '', 'title' => 'Home'),  
          array('url' => 'intro1', 'title' => 'Intro', 'data_template' => 'title_slide'),  
          array('url' => 'code_basic', 'title' => 'Basic', 'data_template' => 'code_layout'),  
          array('url' => 'code_escaping', 'title' => 'Escaping', 'data_template' => 'code_layout'),  
          array('url' => 'code_lists', 'title' => 'Lists', 'data_template' => 'code_layout'),  
          array('url' => 'code_partials', 'title' => 'Partials', 'data_template' => 'code_layout'),  
          array('url' => 'resources', 'title' => 'Resources', 'data_template' => 'title_slide'),  
            
        );
        
        $this->R->template_data['links'] = $links;
        

        //next and previous links
        $this->R->template_data['nav'] = array();
        
        foreach ($links as $key => $link ) {
        
            if ( $link['url'] == $_GET['url'] ) {
                if( isset( $links[ $key+1 ] ) ) {
                    $this->R->template_data['nav']['next'] = $links[ $key+1 ]['url'];
                    $this->R->template_data['nav']['next_data_template'] = $links[ $key+1 ]['data_template'];
                }
                
                if( isset( $links[ $key-1 ] ) ) {
                    $this->R->template_data['nav']['prev'] = $links[ $key-1 ]['url'];
                    $this->R->template_data['nav']['prev_data_template'] = $links[ $key-1 ]['data_template'];
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