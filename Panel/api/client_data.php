<?php
require '../lib/simple_json_res.php';
require '../module/dbconnection.php';


session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	echo('session expired');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    date_default_timezone_set('Europe/London');
    $client_data = $db_connec->getAllQuery('client_data_tb');
    $clients = $db_connec->getAllQuery('client_tb');
    $clients_per_country = $db_connec->getQueryBySql('SELECT country, count(id) FROM client_tb GROUP BY country;');
    
    $data = array('client_data' => $client_data, 'clients' => $clients, 'current_timestamp' => date('Y-m-d H:i:s', strtotime('now')), 'clients_per_country' => $clients_per_country);
    json_response(200, 'success', $data);
}
?>