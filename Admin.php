<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	$AdminRequired = true;
	$json = $_GET['json'];
	
	$move = $_GET[move];
	$rem = $_GET[remove];
	$moveto = $_GET[moveto];
	$roomid = $_GET[roomid];

	if($json == 1) $noheader = true;
	
	if($move) { include("includes/Header.php");  mysql_query("UPDATE `Rooms` SET `movable`='yes' WHERE `id`='".$move."' "); echo "M"; exit(); }
	if($moveto) { include("includes/Header.php");  mysql_query("UPDATE `Rooms` SET `moveTo`='".$moveto."' WHERE `id`='".$roomid."' "); echo "S"; exit(); }
	if($rem) { include("includes/Header.php");  mysql_query("UPDATE `Rooms` SET `movable`='no' WHERE `id`='".$rem."' "); echo ""; exit(); }
	
	include("includes/Header.php"); //includes header
	
	$type = $_GET[Type];
	
	if($type == "AddRooms") include("includes/Admin/AddRoom.php");
	if($type == "todolist") include("includes/Admin/Todolist.php");		
	
	if($json != 1) include("includes/Footer.php"); //includes Footer
?>