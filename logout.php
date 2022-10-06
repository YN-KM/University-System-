<?php
session_start();
unset($_SESSION['userid']);
session_destroy();
$redirect_page = './index.php';
header('location:'.$redirect_page); 
?>