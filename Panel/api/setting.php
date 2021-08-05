<?php
require "../module/dbconnection.php";
require "../lib/simple_json_res.php";

if(isset($_REQUEST['time_interval']) && $_SERVER["REQUEST_METHOD"] === 'POST') {
    $setting = $db_connec->getAllQuery('setting_tb');
    if(count($setting) === 0) {
        $db_connec->insertQuery('setting_tb', array('time_interval' => $_REQUEST['time_interval']));
    }else {
        $db_connec->updateQuery('setting_tb', array('time_interval' => $_REQUEST['time_interval']), array('id' => $setting[0]['id']));
    }
    json_response(200, 'success', null);
}
?>