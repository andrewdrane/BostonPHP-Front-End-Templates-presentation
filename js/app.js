/** JS file for presentation
 * Uses jQuery
 * 
 * 
 */

$( function(){
    
    /** Render mustache templates on the page
     * 
     */
    $('#render-template').on('click', function( event ) {
        event.preventDefault();
        
        //Render the result into the appropriate location
        $('#result').html( 
            Mustache.render( code_layout_template, code_layout_json )
        );
    })
    
    
    
    
    //get and render
    
})

var gotten = '';
//comments that are just a number are for displaying code
//1
    /** Load a request by AJAX. Loads the next and previous links as well
     * Render the template to the main content. Render next and previous and append to the end of the nav bar
     */
    function ajaxLoad( url, template_name ){
        alert('hi');
        
        //Get the data using an AJAX request. getJSON will ensure we get JSON data
        $.getJSON( url, function ( data ) {
            //Render the HTML from the newly gotten data
            var newHTML = Mustache.render( all_templates[template_name], data, all_templates);
            gotten = data;
            //update the main content area
            $('#content').html( newHTML );
            
            //Render the Next and Previous links to the end of the nav bar
            var navHTML = Mustache.render( all_templates['_next_prev'], data['template']['nav'], all_templates);
            
            $('nav').append( navHTML );
        });
        
    }
//1

//helper functions to get examples of things

//Substring helper function, good for getting code from scripts. Use tags like '//start_code1, //end_code1'
function getBetween( tag, data ) {
    
    var start = data.indexOf( '//' + tag ) + tag.length + 2; //start at end of the tag
    var end = data.lastIndexOf( '//' + tag ) - start - 2; //end after last tag
    
    return data.substr( start, end );
}