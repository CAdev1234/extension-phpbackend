<?php
function fetch_clients_data($db_connec) {
    $clients_data = $db_connec->getAllQuery('client_data_tb');
    return $clients_data;
}

function fetch_clients($db_connec) {
    $clients = $db_connec->getAllQuery('client_tb');
    return $clients;
}

function fetch_new_clients($db_connec) {
    $current_date = date('Y-m-d H:i:s', strtotime('now'));
    $yesterday = date('Y-m-d H:i:s', strtotime('-24 hours'));
    
    $sql = "SELECT * FROM client_tb WHERE created_at >= '$yesterday' AND created_at <= '$current_date';";
    $clients = $db_connec->getQueryBySql($sql);
    return $clients;
}

function fetch_clients_top_country($db_connec) {
    $sql = "SELECT country, COUNT(country) AS `count` FROM chrome_dash.client_data_tb group by country ORDER by `count` desc;";
    $clients = $db_connec->getQueryBySql($sql);
    // print_r($clients);
    return $clients;
}

?>
