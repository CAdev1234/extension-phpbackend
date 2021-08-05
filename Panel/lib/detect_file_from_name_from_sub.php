<?php
// Find all files and filenames in a directory that match a substring
function detect_file($directory, $sub_str, $ext) {
    $list = glob("$directory/$sub_str-*.$ext");
    return $list;
}

?>