/** JS file for presentation
 * 
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
    
    
    
})