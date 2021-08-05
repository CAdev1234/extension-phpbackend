<?php
require '../config.php';
require '../module/dbconnection.php';
require '../lib/uuid_gen.php';
require '../lib/simple_json_res.php';
require '../module/getrootpath.php';
require '../lib/detect_file_from_name_from_sub.php';


if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_REQUEST['screenshot'])) {
    $script_path = $_SERVER['SCRIPT_FILENAME'];
    $doc_root = $_SERVER['DOCUMENT_ROOT'];
    $root_path = getRootPathFromServer($script_path, $doc_root);
    
    $client = $db_connec->getQueryByFieldAndValue('client_tb', 'identity', $_REQUEST['ip']);
    if(count($client) === 0) {
        json_response(200, 'upload failed', $_REQUEST['ip']);
        exit();
    }
    $uuid = new UUID;
    $uuid = $uuid->v4();
    $file_name = $client[0]['id'] . "-" . $uuid . '.png';
    $folder = "../upload/image/" . $file_name;


    $list = detect_file('../upload/image', $client[0]['id'], 'png');    

    if (count($list) !== 0) {
        unlink($list[0]);
    }
    
    // remove data:image/png;base64, in base64 data uri
    $img_data = substr($_REQUEST['screenshot'], strpos($_REQUEST['screenshot'], ',') + 1);
    // Move the uploaded image into the image folder
    file_put_contents($folder, base64_decode($img_data));
    $image = array('path' => $ROOT_DIR_PATH ."/upload/image/" . $file_name);
    // $img_id = $db_connec->insertQuery('upload_image', $image);
    // print_r($img_id);
    json_response(200, 'upload success', array('img_path' => $image['path'], 'root_path'=> $root_path));
}
?>