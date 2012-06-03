<?php
//A quick script to output all templates as a JSON object

$templates = array();

//iterate through the template files.
if ($handle = opendir('../templates')) {

    /* loop through each file. */
    while (false !== ($entry = readdir($handle))) {

        //skip non .mustache files
        if( stristr( $entry, '.mustache' ) === false ) {
            continue;

        }

        //Template name is the filename without the extension
        $template_name = str_replace('.mustache', '', $entry );
        //if name like .mustache
        $templates[$template_name] = file_get_contents( '../templates/' . $entry );


    }

    closedir($handle);

}

//echo out all the templates as JSON
echo 'var all_templates = ' . json_encode($templates);