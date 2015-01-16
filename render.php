<?php

function render_templated_files() {
    // get the xml from the xml file
    $xml = simplexml_load_file('xml/demo.xml');

    // get the html from the template
    $template = file_get_contents('template.html');


    // for each book in the xml we want to:
    foreach ($xml->book as $book) {
        $html = $template;

        // get id attribute to use as filename
        foreach ($book->attributes() as $a => $b) {
            if ($a == 'id') {
                $filename = 'job-listings/' . $b . '.html';
            }
        }
        
        // take the xml value and replace the corresponding placeholder text in the template
        foreach ($book as $key => $value) {
            $search = '{{' . $key . '}}';
            $html = str_ireplace($search, $value, $html);
        }

        // write the new html string to a file named for the book id
        $file = fopen($filename, 'wb') or die('Cannot open file.');
        fwrite($file, $html);
        fclose($file);
    }    
}

render_templated_files();

/*

cron command to run this as a cron job everyday at 6 AM:
0 6 * * * /usr/bin/wget http://www.sitename.com/render.php

*/