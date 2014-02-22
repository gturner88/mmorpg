<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header
	
	//Drops Items
	$drops = $_OPOST["drop"];
	
	//checks if drops is set
	if(isset($drops))
	{
		
		//for each value in drops
		foreach($drops as $key => $value)
		{
			
			//checks that value is greater then 0 and is numeric
			if($value > 0 && is_numeric($value))
			{
				
				//Sets Equiped Value to Deleted so player cannot use anymore.
				mysql_query("UPDATE user_Items SET Equiped='Deleted' WHERE Char_id='".$stat[id]."' AND id='".$value."' LIMIT 1");
				
			}
			
		}
	}
?>
<table border="1">
    <tr>
        <th>Admin To Do List</th>
        <th>Moderator To Do List</th>
    </tr>
    <tr>
    	<td valign=top>
        <table bgcolor=lightgreen border=1 valign=top>
        <?

$result = mysql_query("Select * from DB_Main.ToDoList order by Done Asc, Admin Asc, Working DESC, id Asc");
while ($row = mysql_fetch_array($result)) {
  if ($row[Admin] == 'Priority') {
    echo "<tr bgcolor=lightblue>";
  }
  else {
    echo "<tr>";
  }
  echo "<td>$row[Desc]</td><td>$row[Admin]</td><td>$row[Working]</td>";
  if ($row[Done] == 'yes') {
    echo "<td><font color=green>COMPLETED!</font></td></tr>";
  }
  else {
    echo "<td><font color=red>IN-COMPLETED!</font></td></tr>";
  }
}

?>
</table>
</td>
<td valign=top>
<table bgcolor=lightgreen border=1 valign=top>
        <?

$result = mysql_query("Select * from DB_Main.ModToDoList order by Done DESC, Admin Asc, Working DESC, id Asc");
while ($row = mysql_fetch_array($result)) {
  if ($row[Admin] == 'Priority') {
    echo "<tr bgcolor=lightblue>";
  }
  else {
    echo "<tr>";
  }
  echo "<td>$row[Desc]</td><td>$row[Admin]</td><td>$row[Working]</td>";
  if ($row[Done] == 'yes') {
    echo "<td><font color=green>COMPLETED!</font></td></tr>";
  }
  else {
    echo "<td><font color=red>IN-COMPLETED!</font></td></tr>";
  }
}

?>

</table>
</td>
</tr>
</table>


<?php
	
	
	include("includes/Footer.php"); //includes Footer
?>