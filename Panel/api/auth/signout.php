<?php
require "../../config.php";
session_start();
session_destroy();
// Redirect to the login page:
header('Location: ' . $ROOT_DIR_PATH .'/index.php');
?>