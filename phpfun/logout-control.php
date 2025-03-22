<?php
	session_start();
   	$_SESSION['logged'] = 0;
   	$_SESSION['user_login'] = "";
   	$_SESSION['user_name'] = "";
    header('Location: ../index.php');
