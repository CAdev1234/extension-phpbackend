<?php

function fetch_user_data($db_connec, $id) {
    $user = $db_connec->getQueryByFieldAndValue('accounts', 'id', $id);
    return $user[0];
}
?>
