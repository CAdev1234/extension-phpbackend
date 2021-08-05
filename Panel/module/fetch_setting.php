<?php
function fetch_setting($db_connec) 
{
    $setting = $db_connec->getAllQuery('setting_tb');
    // print_r($setting);
    return $setting;
}
?>