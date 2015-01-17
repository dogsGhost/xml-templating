<?php

$config = [
    'xml_src' => 'demo.xml',
    'tmpl_src' => 'template.html',
    'target_dir' => 'output/'
];

function render_templated_files() {
    global $config;

    // get the xml from the xml file
    $xml = simplexml_load_file($config['xml_src']);

    // get the html from the template
    $template = file_get_contents($config['tmpl_src']);

    // for each book in the xml we want to:
    foreach ($xml->book as $item) {
        $html = $template;

        // get id attribute to use as filename
        foreach ($item->attributes() as $attr => $val) {
            if ($attr == 'id') {
                $filename = "{$config['target_dir']}{$val}.html";
            }
        }
        
        // take the xml value and replace the corresponding placeholder text in the template
        foreach ($item as $key => $value) {
            $search = '{{' . $key . '}}';
            $html = str_ireplace($search, $value, $html);
        }

        // write the new html string to a file named for the item id
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