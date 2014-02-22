<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Attack Player"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header
$PH_count = mysql_num_rows(mysql_query("SELECT * FROM `Personal_hitlist` WHERE `Char_id`='".$stat[id]."'"));
$CH_count = mysql_num_rows(mysql_query("SELECT * FROM `Crew_hitlist` WHERE `Crew_id`='".$crew[id]."'"));
echo "<script type=\"text/javascript\" src=\"JQuery.js\"></script><script type=\"text/javascript\">

var attack_player;

function Attackplayer(player_id){  
if(document.getElementById('PH_' + player_id))
{
document.getElementById('PH_' + player_id).innerHTML = '<img style=\"border:medium none;\"src=\"images/CheckMarkSmallRed.gif\">';
}
if(document.getElementById('CH_' + player_id))
{
document.getElementById('CH_' + player_id).innerHTML = '<img style=\"border:medium none;\"src=\"images/CheckMarkSmallRed.gif\">';
}
 document.getElementById('Attack_player').innerHTML = '<div><table style=\"background-color:#666\" height=\"365px\" width=\"550px\" border=\"0\" cellspacing=\"-1\" cellpadding=\"-1\"><tr><td colspan=\"2\" align=\"center\" valign=\"center\"><div style=\"border:solid 2px #000\" id=\"Attack_' + player_id + '_link\">&nbsp;</div></td></tr><tr><td width=\"50%\" align=\"center\"><div style=\"position:relative;background-color:#200000;height:280px;border:solid 2px #000\"><div><iframe onload=\"javascript:gotoRoom();\" src=\"/Attack/?player_id=' + player_id + '\" bgcolor=\"#200000\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"0\" height=\"310px\" scrolling=\"no\" width=\"100%\"></iframe></div></div>';  
 
}
</script><div style=\"position:relative;border:solid 2px #000\" align=center id=\"Attack_player\"></div>

<table width=\"75%\" style=\"border:none;background-color:grey;\"><tr><td colspan=2>
<div style=\"position:relative;border:solid 2px #000\" align=center id=\"Attack_player\"></div>
<div id=\"Errormsg\"></div></td></tr><tr><td align=\"center\" style=\"width:50%;border:solid 2px black;background-color:#222;color:grey;\">Personal HitList (".$PH_count."/".$stat[PH_max].")</td><td align=\"center\" style=\"width:50%;color:grey;border:solid 2px black;background-color:#222;\">Crew HitList (".$CH_count."/".$crew[Hitlist_max].")</td></tr>
<tr><td valign=top>";
if($PH_count > 0) {
echo "
<table width=100% >
<tr><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Player</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Level</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Hits</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Exp Stripped</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">&nbsp;</td></tr>
";
$Personal_hitlist = mysql_query("SELECT * FROM `Personal_hitlist` WHERE `Char_id`='".$stat[id]."'");
	while($perHit = mysql_fetch_array($Personal_hitlist))
	{
		$accHit = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='".$perHit[Hit_id]."'"));
		$mob_spawn = mysql_num_rows(mysql_query("SELECT * FROM user_Attack WHERE Time_back>".$ctime." AND Defender_id=".$accHit[id]." AND Attacker_id='".$stat[id]."' AND Type='Player' Limit 1"));
		if($mob_spawn < 1) { $attackextras = "<a href=\"javascript:void();\" onclick=\"Attackplayer('".$accHit[id]."')\"><img style=\"border:medium none;\"src=\"images/Attack.jpg\"></a>"; }
		else { $attackextras = "<img style=\"border:medium none;\"src=\"images/CheckMarkSmallRed.gif\">"; }
		echo "<tr><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$accHit[name]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$accHit[level]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$perHit[Times_hit]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$perHit[exp_Striped]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\" align=center><div id=\"PH_".$accHit[id]."\">".$attackextras."</div></td></tr>";
	}

echo"
</table>";
}
else
{
	echo "<table width=100% ><tr><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">You have noone on your Personal Hitlist</td></tr></table>";
}
echo "
</td><td valign=top>";
if($CH_count > 0) {
echo "
<table width=100% >
<tr><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Player</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Level</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Hits</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">Exp Stripped</td><td style=\"border:solid 2px black;background-color:#222;color:grey;\">&nbsp;</td></tr>
";
$Crew_hitlist = mysql_query("SELECT * FROM `Crew_hitlist` WHERE `Crew_id`='".$crew[id]."'");
	while($CrewHit = mysql_fetch_array($Crew_hitlist))
	{
		$accHit = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='".$CrewHit[Hit_id]."'"));
		$mob_spawn = mysql_num_rows(mysql_query("SELECT * FROM user_Attack WHERE Time_back>".$ctime." AND Defender_id=".$accHit[id]." AND Attacker_id='".$stat[id]."' AND Type='Player' Limit 1"));
		if($mob_spawn < 1) { $attackextras = "<a href=\"javascript:void();\" onclick=\"Attackplayer('".$accHit[id]."')\"><img style=\"border:medium none;\"src=\"images/Attack.jpg\"></a>"; }
		else { $attackextras = "<img style=\"border:medium none;\"src=\"images/CheckMarkSmallRed.gif\">"; }
		echo "<tr><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$accHit[name]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$accHit[level]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$CrewHit[Times_hit]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">".$CrewHit[exp_Striped]."</td><td style=\"border:solid 2px black;background-color:#999999;color:#222;\" align=center><div id=\"CH_".$accHit[id]."\">".$attackextras."</div></td></tr>";
	}

echo"
</table>";
}
else
{
	echo "<table width=100% ><tr><td style=\"border:solid 2px black;background-color:#999999;color:#222;\">You have noone on your Crew Hitlist</td></tr></table>";
}
echo "</td></tr>
</table>";
include("includes/Footer.php"); ?>