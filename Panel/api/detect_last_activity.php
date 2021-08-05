<?php 
require "../module/dbconnection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['user_identity'])) {
    $client_update = array('last_activity' => date('Y-m-d H:i:s', strtotime('now')));
    $db_connec->updateQuery('client_tb', $client_update, array('identity' => $_REQUEST['user_identity']));
}
?>