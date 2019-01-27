<?php
	$hostname="yourhostname";
	$username="username";
	$pass="yourpass";
	$db="database";
	$conn =new mysqli($hostname,$username,$pass,$db);
	mysqli_set_charset($conn,"utf8");
?>