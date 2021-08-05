<?php
require "../../module/dbconnection.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ( !isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['phone']) ) {
        exit('Please fill both the username and password fields!');
    }
    if ($_POST['password'] !== $_POST['confirm_password']) {
        exit('Password is not matched!');
    }
    $user = array(
        'username'                      => $_REQUEST['username'],
        'password'                      => password_hash($_REQUEST['password'], PASSWORD_DEFAULT), 
        'phone'                         => $_REQUEST['phone'], 
        'email'                         => $_REQUEST['email'],
        'created_at'                    => date('Y-m-d H:i:s', strtotime('now')), 
        'updated_at'                    => date('Y-m-d H:i:s', strtotime('now'))
    );
    $result = $db_connec->insertQuery('accounts', $user);
    header("Location: ../../index.php");
}



?>