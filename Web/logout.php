<?php
session_start();
if(!isset($_SESSION['user_id'])){
    error_log('session not found');
    header('Location: login.php');
    exit();
}
else{
	session_unset();
	header('Location: login.php');
	exit();
}
?>