<? 
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = false;
	$noheader = true;
	
	include("includes/Header.php"); //includes header
	$id = $_GET[id];
	$Item = mysql_fetch_array(mysql_query("SELECT * FROM Item_db WHERE `id`='".$id."'"));
	if($Item[id])
	{
	echo "<div style=\"background-image:URL(http://www-tc.pbs.org/nbr/site/images/blue-background.jpg);font-size:12px\"><table cellspacing=\"0\" cellpadding=\"0\">
	<tr>
	<td style=\"color:white\">
	".$Item[Name]."
	</td>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	<table width=\"100%\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\">";
	if($Item[attack] > 0){ echo "<tr><td style=\"color:#999\">Attack</td><td>&nbsp;</td><td style=\"color:#999\">".add_commas($Item[attack])."</td></tr>";}
	if($Item[hitpoints] > 0){ echo "<tr><td style=\"color:#999\">Hitpoints</td><td>&nbsp;</td><td style=\"color:#999\">".add_commas($Item[hitpoints])."</td></tr>";}
	if($Item[spt] > 0){ echo "<tr><td style=\"color:#999\">Stamina per turn&nbsp;</td><td>&nbsp;</td><td style=\"color:#999\">".add_commas($Item[spt])."</td></tr>";}
	if($Item[ept] > 0){ echo "<tr><td style=\"color:#999\">EXP per turn</td><td>&nbsp;</td><td style=\"color:#999\">".add_commas($Item[ept])."</td></tr>";}
	if($Item[max_stamina] > 0){ echo "<tr><td style=\"color:#999\">Max stamina</td><td>&nbsp;</td><td style=\"color:#999\">".add_commas($Item[max_stamina])."</td></tr>";}
	if($Item[critical] > 0){ echo "<tr><td style=\"color:#999\">Critical</td><td>&nbsp;</td><td style=\"color:#999\">".$Item[critical]."%</td></tr>";}
	if($Item[block] > 0){ echo "<tr><td style=\"color:#999\">Block</td><td>&nbsp;</td><td style=\"color:#999\">".$Item[block]."%</td></tr>";}
	echo "</table>
	</td>
	<td width=\"100px\" Align=\"center\" valign=\"top\">
	<img src=\"".$Item[Image]."\" />
	</td>
	</tr>
	<tr><td colspan=\"2\" style=\"color:#C90\"><i>
	".$Item[Item_des]."
	</i></td></tr>";
	if($Item[Time_limit] == 'yes'){ echo "<tr><td style=\"color:#999\" colspan=2 align=\"right\"><font size=1><i>".$Item[Time_left]." Minutes</i></font></td></tr>";}
	echo "</table></div>";
	}
	else
	{
	echo "<font color=white>Invalid Itemid</font>";
	}
?>