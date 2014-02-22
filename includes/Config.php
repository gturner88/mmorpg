<?php

	$con = mysql_connect("LOCALHOST","Username","Password");
	$db = "DB_Admin";
	$maindb = "DB_Main";
	mysql_select_db($db, $con);
	$ctime = time() + 3600;

?>