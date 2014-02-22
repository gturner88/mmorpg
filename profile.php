<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Player Profile"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header

 $id=$_GET[id];
 if($id == "")
 {
  $profileuser = mysql_query("select * from users where id='".$stat[id]."' Limit 1");
  $profile = mysql_fetch_array($profileuser);
 }
 else
 {  
  $profileuser = mysql_query("select * from users where id='".$id."' Limit 1");
  $profile = mysql_fetch_array($profileuser);
 }
 if($stat[id]==$profile[id]){$up="yes";}else{$up="no";}
 $count = mysql_num_rows($profileuser);
 if($count == 1)
 {
	 $addhitcrew = $_GET[addcrewhitlist];
	 if($addhitcrew)
	 {
		$crewhitmax = mysql_num_rows(mysql_query("SELECT * FROM `Crew_hitlist` WHERE `Crew_id`='".$stat[id]."'"));
		$crewhitcount = mysql_num_rows(mysql_query("SELECT * FROM `Crew_hitlist` WHERE `Crew_id`='".$stat[id]."' AND `Hit_id`='".$profile[id]."'"));
 		if($crewRank[Hitlist] == 1) {
			if($crewhitcount > 0) { $Errormessage = $profile[name]." Already added to hitlist"; } else {
	 			if($crewhitmax <= $crew[Hitlist_max]) {	
					mysql_query("INSERT INTO Crew_hitlist (Crew_id, Hit_id) VALUES(".$stat[id].",".$profile[id].")");
					$Errormessage = $profile[name]." added to crew hitlist";
				}
				else {
					$Errormessage = "You have hit Your max amount of people allowed on your crew hitlist";
				}
			}
		}
		else
		{
			$Errormessage = "You do not have the correct permissions to add to crew hitlist";
		}
	 }
	 $addhitper = $_GET[addhitlist];
	 if($addhitper)
	 {
		$perhitmax = mysql_num_rows(mysql_query("SELECT * FROM `Personal_hitlist` WHERE `Char_id`='".$stat[id]."'"));
		$perhitcount = mysql_num_rows(mysql_query("SELECT * FROM `Personal_hitlist` WHERE `Char_id`='".$stat[id]."' AND `Hit_id`='".$profile[id]."'"));
 		if($perhitcount > 0) { $Errormessage = $profile[name]." Already added to hitlist"; } else {
	 		if($perhitmax <= $stat[PH_max]) {	
				mysql_query("INSERT INTO Personal_hitlist (Char_id, Hit_id) VALUES(".$stat[id].",".$profile[id].")");
				$Errormessage = $profile[name]." added to hitlist";
			}
			else {
				$Errormessage = "You have hit Your max amount of people alloud on your personal hitlist";
			}
		}
	 }
echo "<script type=\"text/javascript\" src=\"JQuery.js\"></script><script type=\"text/javascript\">

var attack_player;

function Attackplayer(player_id){  
document.getElementById('PH_' + player_id).innerHTML = '<img style=\"border:medium none;\"src=\"images/CheckMarkSmallRed.gif\"><u>Attack</u>';
 document.getElementById('Attack_player').innerHTML = '<div><table style=\"background-color:#666\" width=\"550px\" border=\"0\" cellspacing=\"-1\" cellpadding=\"-1\"><tr><td colspan=\"2\" align=\"center\" valign=\"center\"><div style=\"border:solid 2px #000\" id=\"Attack_' + player_id + '_link\">&nbsp;</div></td></tr><tr><td width=\"50%\" align=\"center\"><div style=\"position:relative;background-color:#200000;height:280px;border:solid 2px #000\"><div><iframe onload=\"javascript:gotoRoom();\" src=\"/Attack/?player_id=' + player_id + '\" bgcolor=\"#200000\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"0\" height=\"310px\" scrolling=\"no\" width=\"100%\"></iframe></div></div>';  
 
}
</script><div style=\"position:relative;border:solid 2px #000\" align=center id=\"Attack_player\"></div>
<b><div id=\"Errormsg\" style=\"color:red;\">".$Errormessage."</div></b><table bgcolor=\"#111111\" valign=top height=\"100%\" width=\"100%\"><tr><td colspan=2 align=right bgcolor=black>
";
if($profile[id] != $stat[id])
{
$mob_spawn = mysql_num_rows(mysql_query("SELECT * FROM user_Attack WHERE Time_back>".$ctime." AND Defender_id=".$profile[id]." AND Attacker_id='".$stat[id]."' AND Type='Player' Limit 1"));
	if($mob_spawn < 1) { $attackextras = "<a style=\"color:#999999\" href=\"javascript:void();\" onclick=\"Attackplayer(".$profile[id].")\"><img style=\"border:medium none;\"src=\"images/Attack.jpg\">Attack</a>"; }
	else { $attackextras = "<img style=\"border:medium none;\"src=\"images/CheckMarkSmallRed.gif\">Attack"; }
		
echo"
<table width=100% align=right bgcolor=black >
<tr><td width=50%></td><td></td><td align=right style=\"color:#999999\">Message</td></tr>
<tr><td></td><td></td><td align=right style=\"color:#999999\"><div id=\"PH_".$profile[id]."\">".$attackextras."</div></td></tr>
<tr><td></td><td align=right style=\"color:#999999\"><a style=\"color:#999999\" href=\"?id=".$profile[id]."&addcrewhitlist=1\">Add To Crew Hitlist</a></td><td align=right style=\"color:#999999\"><a style=\"color:#999999\" href=\"?id=".$profile[id]."&addhitlist=1\">Add To Personal Hitlist</a></td></tr>
</table>";
}
echo "
</td></tr><tr><td bgcolor=\"#111111\" valign=top><table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
  <tbody><tr>
    <td width=\"100%\">
    
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"8\" width=\"100%\">
      <tbody><tr>
        <td style=\"border-right: 2px dashed; color:#666666\" align=\"left\" valign=\"top\" width=\"50%\">
        
        <table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
          <tbody><tr>

            <td colspan=\"2\" align=\"center\" bgcolor=\"#200000\" width=\"100%\">
              <font color=\"#660000\"><b>PLAYER INFO</b></font>
	       </td>
          </tr>
          <tr>
            <td bgcolor=\"#400000\" colspan=2 width=\"100%\" align=center><b><font size=\"4\">".$profile[name]."</font></b></td>
          </tr>
          <tr>
            <td bgcolor=\"#200000\" width=\"50%\"><b><font size=\"1\">CLASS</font></b></td>
            <td bgcolor=\"#200000\" width=\"50%\"><b><font size=\"2\">Level ".$profile[level]."</font></b></td>

          </tr>
                    <tr>
            <td bgcolor=\"#400000\" width=\"50%\"><b><font size=\"1\">EXPERIENCE</font></b></td>
    <td bgcolor=\"#400000\" width=\"50%\"><b><font size=\"2\">".add_commas($profile[exp])."</font></b></td>
          </tr>
          
          <tr>
            <td bgcolor=\"#200000\" width=\"50%\"><b><font size=\"1\">GROWTH YESTERDAY</font></b></td>

            <td bgcolor=\"#200000\" width=\"50%\"><b><font size=\"2\">".add_commas($profile[Y_growth])."</font></b></td>
          </tr>
                    
          <tr>
            <td bgcolor=\"#400000\" width=\"50%\"><b><font size=\"1\">MENTOR</font></b></td>
            <td bgcolor=\"#400000\" width=\"50%\"><b><font size=\"2\">".$profile[Mentor]."</font></b></td>
          </tr>
                    <tr>

          	<td colspan=\"2\" align=\"center\" bgcolor=\"#200000\" width=\"100%\">
            	<b><font size=\"2\"></font></b>
          	</td>
          </tr>
                    <tr>
          	<td colspan=\"2\" width=\"100%\" align=center>
          			<img src=\"profile/".$profile[id].".gif\">
          			"; if($up=="yes"){echo"<br> [ <a class=\"link1\" href=\"upload.php\">Upload</a> ] ";} echo "
	          	</td>

          </tr>

        </tbody></table>
<table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
          <tbody><tr>

              <td align=\"center\" bgcolor=\"#200000\" width=\"100%\">
                                <font color=\"#660000\"><b>Comments</b></font>
              </td>
           </tr>
       </tbody></table>
            <table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
						  <tbody><tr>
			  				<td align=\"center\" width=\"100%\">
                                                          <font color=white><b><i><u>Coming Soon</u></i></b></font>
							</td>
			  			</tr>
			  				
				</tbody></table>
      

 
     </td>        
    <td height=\"100%\" valign=\"top\" width=\"50%\">
       	
       <table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
          <tbody><tr>
          	<td align=\"center\" bgcolor=\"#200000\" width=\"100%\">
          		<font color=\"#660000\"><b>DESCRIPTION</b>"; if($up=="yes"){echo" [ <a class=\"link1\" href=\"advancedprofile.php\">Edit</a> ] ";} echo "</font></td>

          </tr>
          <tr>
          		<td align=\"left\" width=\"100%\">
                <font color=white>".$profile[Description]."</font>
                 </td>
          </tr>
	
       </tbody></table>
       <table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
          <tbody><tr>

              <td align=\"center\" bgcolor=\"#200000\" width=\"100%\">
                                <font color=\"#660000\"><b>EQUIPMENT</b></font>
              </td>
           </tr>
       </tbody></table>
            <table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
						  <tbody><tr>
			  				<td align=\"center\" width=\"100%\">";
                                                          echo "<div style=\"position:relative; width:300px; height:385px;background-image:url(/images/equipment-bg.jpg);\">";
	$user_head = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Head]."' Limit 1"));
	$head = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_head[Item_id]."'"));
	
	$user_neck = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Neck]."' Limit 1"));
	$neck = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_neck[Item_id]."'"));
	
	$user_weapon = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Weapon]."' Limit 1"));
	$weapon = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_weapon[Item_id]."'"));
	
	$user_chest = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Chest]."' Limit 1"));
	$chest = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_chest[Item_id]."'"));
	
	$user_shield = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Shield]."' Limit 1"));
	$shield = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_shield[Item_id]."'"));
	
	$user_belt = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Belt]."' Limit 1"));
	$belt = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_belt[Item_id]."'"));
	
	$user_legs = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Legs]."' Limit 1"));
	$legs = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_legs[Item_id]."'"));
	
	$user_ring = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Ring]."' Limit 1"));
	$ring = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_ring[Item_id]."'"));
	
	$user_boots = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$profile[id]."' AND Equiped='yes' AND id='".$profile[eq_Boots]."' Limit 1"));
	$boots = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_boots[Item_id]."'"));
        
		///Head
        echo "<div style=\"position:absolute; left:118px; top:7px; width:62px; height:46px;text-align:center\">";
        if($user_head[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$head[Image]."\" onMouseover=\"ajaxtooltip('".$head[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	
	///Neck
	echo "<div style=\"position:absolute; left:197px; top:12px; width:41px; height:41px;text-align:center\">";
        if($user_neck[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$neck[Image]."\" onMouseover=\"ajaxtooltip('".$neck[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	///Weapon
	echo "<div style=\"position:absolute; left:45px; top:67px; width:56px; height:96px;text-align:center\">";
        if($user_weapon[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$weapon[Image]."\" onMouseover=\"ajaxtooltip('".$weapon[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
        ///Chest
	echo "<div style=\"position:absolute; left:121px; top:67px; width:56px; height:96px;text-align:center\">";
        if($user_chest[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$chest[Image]."\" onMouseover=\"ajaxtooltip('".$chest[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	///Shield
	echo "<div style=\"position:absolute; left:198px; top:67px; width:56px; height:96px;text-align:center\">";
        if($user_shield[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$shield[Image]."\" onMouseover=\"ajaxtooltip('".$shield[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	///pants
	echo "<div style=\"position:absolute; left:118px; top:175px; width:62px; height:75px;text-align:center\">";
        if($user_legs[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$legs[Image]."\" onMouseover=\"ajaxtooltip('".$legs[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	///belt
	echo "<div style=\"position:absolute; left:61px; top:192px; width:41px; height:41px;text-align:center\">";
	if($user_belt[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$belt[Image]."\" onMouseover=\"ajaxtooltip('".$belt[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	///ring
	echo "<div style=\"position:absolute; left:197px; top:192px; width:41px; height:41px;text-align:center\">";
        if($user_ring[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$ring[Image]."\" onMouseover=\"ajaxtooltip('".$ring[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
	///legs
	echo "<div style=\"position:absolute; left:118px; top:262px; width:62px; height:66px;text-align:center\">";
        if($user_boots[Char_id] == $profile[id])
        {
		echo "<img style=\"border:0px;\" src=\"".$boots[Image]."\" onMouseover=\"ajaxtooltip('".$boots[id]."', this, event)\" onMouseout=\"delayhidetip()\" >";	
	}
	echo "</div>";
echo "</div>
							</td>
			  			</tr>
			  				
				</tbody></table>
						<table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
         		<tbody><tr>

            	<td align=\"center\" bgcolor=\"#200000\" width=\"100%\">
               <font color=\"#660000\"><b>MEDALS</b></font>
             </td>
          	</tr>
          <tr>
         		<td align=\"center\">
                           <font color=white><b><i><u>Coming Soon</u></i></b></font>
        		</td>
        	</tr>
        </tbody></table>
<table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
          <tbody><tr>

              <td align=\"center\" bgcolor=\"#200000\" width=\"100%\">
                                <font color=\"#660000\"><b>Followers</b></font>
              </td>
           </tr>
       </tbody></table>
            <table style=\"padding: 10px;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">
						  <tbody><tr>
			  				<td align=\"center\" width=\"100%\">
                                                          <font color=white><b><i><u>Coming Soon</u></i></b></font>
							</td>
			  			</tr>
			  				
				</tbody></table></table>
        			</td>
        		</tr>
    </table>
    </td>
  </tr>
</table>
</div>
</center>";
		}
		else
		{
		$ERROR = "Invalid Profile id";
		include("includes/Error.php");
		}
	
	
	include("includes/Footer.php"); //includes Footer
?>