<?php
require "../module/dbconnection.php";
require "../lib/simple_json_res.php";
function deleteAll($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file)) deleteAll($file);
        else unlink($file);
    }
}

$db_connec->delQueryAll('client_data_tb');
$db_connec->delQueryAll('client_tb');
// delete all images
deleteAll('../upload/image');
json_response(200, 'delete success', '');
?>