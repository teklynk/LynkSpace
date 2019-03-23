#!/usr/bin/php
<?php
function dirToArray($dir, $fileIgnoreArray = array()) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value,array(".",".."))) {
            if ( in_array( $value, $fileIgnoreArray ) ) {
                continue;
            }
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}

print_r (dirToArray(__DIR__ . '/../htdocs/uploads', array('.gitkeep')));
?>