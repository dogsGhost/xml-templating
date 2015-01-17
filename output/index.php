<?php
  function get_dir_contents() {
    $string = '';
    if ($handle = opendir('.')) {
      // Loop over current directory.
      while (false !== ($entry = readdir($handle))) {
        // Ignore files/folders starting with a period.
        if (strpos($entry, '.') !== 0) {
          // Skip the index file.
          if ($entry !== 'index.php') {
            // Check if the item is a file or a folder.
            if (!strpos($entry, '.')) {
              $file = $entry . '/';
            } else {
              $file = $entry;
            }
            // Add link item to the string.
            $string .= '<li><a href="' . $file . '">' . $file . '</a></li>';
          }

        }
      }
      closedir($handle);
    }
    if (!$string) {
      return '<li>no results</li>';
    }
    return $string;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Automatic Index</title>
  <style>
    body {
      color: #222;
      font: 18px/1.5 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }
    a {
      color: #13b0bf;
      text-decoration: none;
    }
    a:visited {
      color: grey;
    }
    a:hover {
      color: red;
    }
  </style>
</head>
<body>
  <ol>
    <?php echo get_dir_contents(); ?>
  </ol>
</body>
</html>