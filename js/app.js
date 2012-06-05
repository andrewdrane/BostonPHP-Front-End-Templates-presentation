/** JS file for presentation
 * Uses jQuery
 * 
 * 
 */

$( function(){
    
    /** Render mustache templates on the page
     * 
     */
    $(document).on( 'click', '#render-template', function( event ) {
        event.preventDefault();
        
        //Render the result into the appropriate location
        $('#result').html( 
            Mustache.render( code_layout_template, code_layout_json, all_templates )
        );

        //get rid of the link
        $(this).remove();
    });
    
    
    //Setup the next and previous links as ajax
    $(document).on( 'click', '#next a, #prev a', function( event ) {
        event.preventDefault();
        //Use the data templates for the next and previous buttons. Use window.location.pathname because I'm using confusing URLs here
        ajaxLoad( $(this).attr('href'), $(this).attr('data-template') )
    });
    
    // Use arrow keys easy next and previous
    $(document).unbind('keydown').bind('keydown', function(event) {

        //If the big preview is open
        if( event.keyCode == 37 && $('#prev').length ) {
            $('#prev a').trigger('click');
            return false;
        }
        if( event.keyCode == 39 && $('#next').length ) {
            $('#next a').trigger('click');
            return false;
        }
        
        return true; //for other keypresses, return true
    });
    
    
    prettyPrint(); //make code blocks look nice!
    formatJSON(); //make json look nice
    //get and render
    
})

var gotten = '';
//comments that are just a number are for displaying code
//1
/** Load a request by AJAX. Loads the next and previous links too.
 * Render the template to the main content. 
 * Render next and previous and append to the end of the nav bar
 */
function ajaxLoad( url, template_name ){

    // Get the data using an AJAX request. 
    // getJSON will ensure we get JSON data
    $.getJSON( url, function ( data ) {
        //Render the HTML from the newly gotten data
        var newHTML = Mustache.render( 
            all_templates[template_name], 
            data, 
            all_templates
        );

        //update the main content area
        $('#content').html( newHTML );

        //Render the Next and Previous links to the end of the nav bar
        //get rid of the existing ones
        $('#prev, #next').remove(); 

        var navHTML = Mustache.render( 
            all_templates['_next_prev'], 
            data['template'], 
            all_templates
        );

        $('#nav').append( navHTML );

        prettyPrint(); //make code blocks look nice!
        formatJSON(); //make json look nice
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

//Make json look pretty
function formatJSON(){
    //first, make sure there is json_data and that it hasn't already been formatted
    if( !$('#json_data').length || $('#json_data').is('formatted') ) return; //avoid double formatting
    $('#json_data').html( $('#json_data').html().replace(/(\{|\[|\])/g, '\n$1').replace(/(\])/g, '$1\n') ).addClass('formatted');
}

//load an example script into a a pretty print code block
function loadUpScript() {
    $.get( file_url, function( data ) {
        //extract the part we want to see
        var example = getBetween( file_token, data );

        //update the display thing
        $("#function_example").html( example );
        
        //run the google code hilighting
        prettyPrint();
        

    });
}
