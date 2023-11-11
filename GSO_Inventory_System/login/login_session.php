<?php
session_start();
if (!$_SESSION['employeeid']) {
	header('Location:../login/login.php');
	exit();
}
?>