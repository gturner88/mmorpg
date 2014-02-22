<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "World"; //title of document
	$isLoggedIn = true;
	$noheader = true;
	
	include("includes/Header.php"); //includes header
	include("includes/QuestFunctions.php");

$room = $_GET['room'];
if($room == "" || $room == 0)
{
 $room = $stat[C_Room];
 $N_room = mysql_fetch_array(mysql_query("SELECT * FROM Rooms WHERE `id`='".$room."'"));
}
else
{
 $C_Room = mysql_fetch_array(mysql_query("SELECT * FROM Rooms WHERE `id`='".$stat[C_Room]."'"));
 $N_room = mysql_fetch_array(mysql_query("SELECT * FROM Rooms WHERE `id`='".$room."'"));
 $lastroom =  $stat[C_Room];
 if($lastroom == $room){}
 elseif($stat[Rank] == "Admin"){}
 elseif($room == 1){}
 elseif($C_Room[Lat] == $N_room[Lat] + 1){}
 elseif($C_Room[Lat] == $N_room[Lat] - 1){}
 elseif($C_Room[Long] == $N_room[Long] + 1){}
 elseif($C_Room[Long] == $N_room[Long] - 1){}
 else
 {
  $errormessage = "Hacking Attempt";
    echo '{
  "Errormsg": "'.$errormessage.'"
  }';
  exit();
 }
 if($N_room[Room_key])
 {
  $key = mysql_num_rows(mysql_query("SELECT * FROM Item_db WHERE Char_id='".$stat[id]."' AND Name='".$N_room[Room_key]."'"));
  if($key < 1)
  {
  $errormessage = $N_room[N_key];
  echo '{
  "Errormsg": "'.$errormessage.'"
  }';
  exit();
  }
 }
 if($N_room[moveTo] > 0)
 {
	 $room=$N_room[moveTo];
	 $N_room = mysql_fetch_array(mysql_query("SELECT * FROM Rooms WHERE `id`='".$room."'"));
 }
 mysql_query("UPDATE users SET C_Room='".$room."' WHERE id='".$stat[id]."'");
 mysql_query("UPDATE users SET Room_Time='".$ctime."' WHERE id='".$stat[id]."'");
}
if($stat[stamina] >= $stat[max_stamina])
{
 $stamcolor = "color=green";
}
echo '{
';
echo ' "pic":"<image width=\"250\" height=\"250\" src=\"'.$N_room[Room_image].'\">",
';
echo ' "name": "'.$N_room[Room_name].'",
';
echo ' "mapHtml":"';
	for($i= $N_room[Lat] - 3;$i < $N_room[Lat] + 4; $i++)
    {
		echo '<table cellpadding=\"0\" cellspacing=\"0\"><tr>';		
		for($j=$N_room[Long] - 3;$j < $N_room[Long] + 4; $j++)
		{
			$northr = $N_room[Lat] - 1;
			$southr = $N_room[Lat] + 1;
			$eastr = $N_room[Long] + 1;
			$westr = $N_room[Long] - 1;
			$Room_N = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Lat`='".$northr."' AND `Long`='".$N_room[Long]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
			$Room_S = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Lat`='".$southr."' AND `Long`='".$N_room[Long]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
			$Room_E = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Long`='".$eastr."' AND `Lat`='".$N_room[Lat]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
			$Room_W = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Long`='".$westr."' AND `Lat`='".$N_room[Lat]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
			$Room = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `id`='".$room."'"));		
			if($j == $Room[Long] - 3 && $i == $Room[Lat] && $Room_W[id]) $extraperm = '<img src=\"images/W_arrow.jpg\">';
			if($j == $Room[Long] + 3 && $i == $Room[Lat] && $Room_E[id]) $extraperm = '<img src=\"images/E_arrow.jpg\">';
			if($j == $Room[Long] && $i == $Room[Lat] - 3 && $Room_N[id]) $extraperm = '<img src=\"images/N_arrow.jpg\">';
			if($j == $Room[Long] && $i == $Room[Lat] + 3 && $Room_S[id]) $extraperm = '<img src=\"images/S_arrow.jpg\">';
			if($j == $Room[Long] && $i == $Room[Lat]) $extraperm = '<img src=\"images/gemRed.png\">';
			if(!is_file('images/Map/Section'.$Room[Section].'/Section'.$Room[Section].'-'.$i.'-'.$j.'.jpg')) { 			
				echo '<td align=center valign=center style=\"width:25px;height:25px;background-color:black;\')\">'.$extraperm.'</td>';
			}
			else
			{
			echo '<td align=center valign=center style=\"width:25px;height:25px;background-image:URL(\'images/Map/Section'.$Room[Section].'/Section'.$Room[Section].'-'.$i.'-'.$j.'.jpg\')\">'.$extraperm.'</td>';
			}
			$extraperm = "";
		}
		echo "</tr>";
	}
	echo "</table>\",
";
echo ' "mappic": "'.$N_room[Room_map].'",
';
$northr = $N_room[Lat] - 1;
$southr = $N_room[Lat] + 1;
$eastr = $N_room[Long] + 1;
$westr = $N_room[Long] - 1;
$Room_N = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Lat`='".$northr."' AND `Long`='".$N_room[Long]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
echo ' "north": "'.$Room_N[id].'",
';
$Room_S = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Lat`='".$southr."' AND `Long`='".$N_room[Long]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
echo ' "south": "'.$Room_S[id].'",
';
$Room_E = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Long`='".$eastr."' AND `Lat`='".$N_room[Lat]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
echo ' "east":  "'.$Room_E[id].'",
';
$Room_W = mysql_fetch_array(mysql_query("SELECT * FROM `Rooms` WHERE `Long`='".$westr."' AND `Lat`='".$N_room[Lat]."' AND Section='".$N_room[Section]."' AND `movable`='yes'"));
echo ' "west": "'.$Room_W[id].'",
';
echo ' "curRoom": "'.$room.'",
';
echo ' "curTime": "Time: '.date("g:i a", $ctime).'",
';
echo ' "Section": "'.$Room[Section].'",
';
echo ' "curStamina": "<font '.$stamcolor.'>Stamina: '.add_commas($stat[stamina]).'</font>",
';
echo ' "roomDetails":"<table width=\"100%\" align=\"center\"><tr ><td valign=\"top\" colspan=\"3\"><u><b>Mobs in the room</b></u></td></tr>';
              $mobs = mysql_query("SELECT * FROM mob_Rooms WHERE room_id='".$room."'");
              while($mobID = mysql_fetch_array($mobs)) 
              {
			   $mob = mysql_fetch_array(mysql_query("SELECT * FROM mobs WHERE id='".$mobID[mob_id]."' LIMIT 1"));
               $mob_spawn = mysql_num_rows(mysql_query("SELECT * FROM user_Attack WHERE Time_back>".$ctime." AND Win='yes' AND Defender_id=".$mobID[id]." AND Attacker_id='".$stat[id]."' AND Type='Mob' Limit 1"));
               if($mob_spawn == 0)
               {
				
				$Quests = false;

				$QuestStep = mysql_num_rows(mysql_query("SELECT * FROM `Quest_Steps` WHERE `Mob_id`='".$mobID[mob_id]."'"));				
				if($QuestStep > 0) 
					if(isCurStep($stat[id], $mobID[mob_id]) == true) 
						$Quests = true;
				
                if($mob[Level] == $stat[level]){$color = "yellow";}if($mob[Level] > ($stat[level])){$color = "#FC3";}if($mob[Level] < ($stat[level])){$color = "#9F3";}if($mob[Level] > ($stat[level] + 5)){$color = "orange";}if($mob[Level] < ($stat[level] - 5)){$color = "#CF6";}if($mob[Level] > ($stat[level] + 10)){ $color = "red";}if($mob[Level] < ($stat[level] - 10)){$color = "green";}
                if($mob[Quest_only] == 'no') { $mobattack = '<a href=\"javascript:void();\" onclick=\"Attackmob(\''.$mobID[id].'\')\"><img style=\"border:none;\" src=\"images/Attack.jpg\"></a>'; } else { $mobattack = ""; }
				echo '<tr id=\"mob_'.$mobID[id].'\"><td align=\"left\" valign=\"top\" width=\"100%\"><a style=\"text-decoration:none;color:'.$color.';\" href=\"javascript:LoadMob('.$mobID[id].');\">'.$mob[Name].' ['.$mob[Level].']</a></td><td align=\"right\">';
				if($Quests == true) echo '<a href=\"javascript:LoadMob('.$mobID[id].');\"><img src=\"http://www.hrwiki.org/w/images/1/1e/Talk.png\" /></a>';
				echo '</td><td align=\"right\">'.$mobattack.'</td></tr>';
                $color = "";
               }
              }
              echo '<tr><td valign=\"top\" colspan=\"3\"><u><b>Players in the room</b></u></td></tr>';
                        $ttime = $ctime - 900;
              $players = mysql_query("SELECT * FROM users WHERE Room_Time>='".$ttime."' AND id <> '".$stat[id]."' AND C_room='".$room."'");
              while($player = mysql_fetch_array($players)) 
              {
              if($player[level]==$stat[level]){$color="yellow";}if($player[level]>($stat[level])){$color="#FC3";}if($player[level]<($stat[level])){$color="#9F3";}if($player[level]>($stat[level]+5)){$color="orange";}if($player[level]<($stat[level]-5)){$color="#CF6";}if($player[level]>($stat[level]+10)){$color="red";}if($player[level]<($stat[level]-10)){$color="green";}
               echo '<tr><td align=\"left\" valign=\"top\" colspan=\"2\" width=\"100%\"><a style=\"text-decoration:none;color:'.$color.';\" href=\"profile.php?id='.$player[id].'\">'.$player[name].' ['.$player[level].']</a></td><td align=\"right\">Attack</td></tr>';
                 $color = "";
               }
              echo '</table>"
';
echo '}';
?>