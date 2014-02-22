<?php

	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = false;
	$noheader = true;
	$myaccount = 1;
	
	include("includes/Header.php"); //includes header	
	if($Main_Login == true)
	{
		echo "<a onClick=\"javascript:maininfo();\"><img src=\"images/characters.jpg\" style=\"cursor:pointer\" /></a>
				<img src=\"images/create.jpg\" style=\"cursor:pointer\" />
				<img src=\"images/options.jpg\" style=\"cursor:pointer\" />
				<img src=\"images/edit.jpg\" style=\"cursor:pointer\" />";
		$accounts = mysql_query("SELECT * FROM users WHERE account_id='".$account[id]."'");
		echo "<table width=100%><tr><td bgcolor=black><font color=\"#666666\">Pp</font></td><td bgcolor=black><font color=\"#666666\">Character</font></td><td bgcolor=black><font color=\"#666666\">Level</font></td><td bgcolor=black><font color=\"#666666\">Crew</font></td><td bgcolor=black><font color=\"#666666\"></font></td></tr>";
		while($row = mysql_fetch_array($accounts)) 
		{
		  echo "<tr><td></td><td>".$row[name]."</td><td>".$row[level]."</td><td></td><td><a href=\"index.php?uid=".$row[id]."\">Play!</a></td></tr>";
		}
		echo "</table>";
	}
	else
	{
		echo "Not Logged In!";
	}
?>