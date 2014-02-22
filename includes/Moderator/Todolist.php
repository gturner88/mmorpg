<?

$markdone = $_GET[markdone];
$add = $_GET[add];
$addit = $_GET[addit];
$changepriority = $_GET[changepriority];
$cpriority = $_GET[cpriority];
$working = $_GET[working];
$onhold = $_GET[onhold];
if ($working) {
  mysql_query("UPDATE DB_Main.ModToDoList SET Working='".$stat[name]."' WHERE id='".$working."'");
  echo "You Have set your current project<br>";
}
if ($onhold) {
  mysql_query("UPDATE DB_Main.ModToDoList SET Working='On Hold' WHERE id='".$onhold."'");
  echo "You Have set your current project<br>";
}
if ($markdone) {
  mysql_query("UPDATE DB_Main.ModToDoList SET Done='yes' WHERE id=$markdone");
  echo "Job marked as complete<br>";
}
if ($add) {
  echo "
   <form action='?Type=todolist&addit=yes' method=post>
   <select name=Admin>
    <option value='Priority'>Priority</option>
    <option value='Secondary'>Secondary</option>
   </select><br>
   Description <input type=text name=Desc><br>
   <input type=submit value='Add New Job'>
   </form>
  ";
}
if ($addit) {
  $Desc = $_POST[Desc];
  $Admin = $_POST[Admin];
  $sql="INSERT INTO DB_Main.ModToDoList (`Desc`, `Admin`) VALUES ('$Desc', '$Admin')";
  if (!mysql_query($sql,$con)) {
    die('Error: ' . mysql_error());
  }
}
if ($changepriority) {
  echo "<form action='?Type=todolist&cpriority=$changepriority' method=post>
   <select name=prior>
    <option>Priority</option>
    <option>Secondary</option>
   </select>
   <input type=submit value=Change>
   </form>
  ";
}
if ($cpriority) {
  $prior = $_POST[prior];
  mysql_query("update DB_Main.ModToDoList set Admin = '".$prior."' where id='".$cpriority."'");
}
echo "<a href='?Type=todolist&add=yes'>Add New Job</a>";

echo "<table bgcolor=lightgreen border=1>";
$result = mysql_query("Select * from DB_Main.ModToDoList order by Done, Admin, id Asc");
while ($row = mysql_fetch_array($result)) {
  if ($row[Admin] == 'Priority') {
    echo "<tr bgcolor=lightblue>";
  }
  else {
    echo "<tr>";
  }
  echo "<td>$row[Desc]</td><td>$row[Admin]</td><td>$row[Working]</td>";
  if ($row[Done] == 'yes') {
    echo "<td><font color=red>COMPLETED!</font></td></tr>";
  }
  else {
    echo "<td><a href='?Type=todolist&markdone=$row[id]'>Mark Complete</a></td><td><a href='?Type=todolist&changepriority=$row[id]'>Change Priority</a></td><td><a href='?Type=todolist&working=$row[id]'>Work On</a></td><td><a href='?Type=todolist&onhold=$row[id]'>On Hold</a></td></tr>";
  }
}

?>
</table>