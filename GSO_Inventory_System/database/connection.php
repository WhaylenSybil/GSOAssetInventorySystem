<?php

$connect = mysqli_connect("localhost", "root", "", "db_gso") or die(mysql_error());

if (!$connect) {
	die("Connection Failed").mysqli_connect_error();
}
?>