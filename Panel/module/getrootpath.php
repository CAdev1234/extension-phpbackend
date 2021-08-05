<?php 
function getRootPathFromServer($script_path, $doc_root) {
    $root_path = str_replace($doc_root, '', $script_path);
    $root_path = substr($root_path, 0, strpos($root_path, 'pages'));
    return $root_path;
}
?>