<?php

	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "World"; //title of document
	$isLoggedIn = true;
	$noheader = true;
	
	include("includes/Header.php"); //includes header
	
	$Mina_Section = $_GET[section];

	$Section_Images = mysql_query("SELECT * FROM `Rooms` WHERE Section='".$Mina_Section."'");
	
	$Section_Num = mysql_num_rows($Section_Images);
	
	$count = 0;

?>
{
	"Images" : [<?php
	while($Section_Image = mysql_fetch_array($Section_Images))
	{
		$count++;
		echo "\n\t\t{ \"Image\" : \"images/Map/Section".$Section_Image[Section]."/Section".$Section_Image[Section]."-".$Section_Image[Lat]."-".$Section_Image[Long].".jpg\" }"; 
		if($count != $Section_Num) echo ","; else echo "\n";
	}

?>
    ]
}
