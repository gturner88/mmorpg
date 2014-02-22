<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	$playerRankRequired = 2;
	$json = $_GET['json'];
	
	include("includes/Header.php"); //includes header
	
	$type = $_GET[Type];
	
	if($type == "todolist") include("includes/Moderator/Todolist.php");		
	
	if($json != 1) include("includes/Footer.php"); //includes Footer
?>