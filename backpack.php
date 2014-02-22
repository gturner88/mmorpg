<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	$noheader = true;
	
	include("includes/Header.php"); //includes header
	
	/* border:2px solid #F00; */
	$equip = $_GET[equip];
	$vault = $_GET[vault];
	if($equip)
	{
		$user_item = mysql_fetch_array(mysql_query("Select * FROM user_Items WHERE id='".$equip."' AND Char_id='".$stat[id]."' AND `Equiped`='no' LIMIT 1"));
		$item = mysql_fetch_array(mysql_query("Select * FROM Item_db WHERE id='".$user_item[Item_id]."'"));
		if($stat["eq_".$item[Slot]] != 0)
		{
			mysql_query("UPDATE user_Items SET `Equiped`='no' WHERE id='".$stat["eq_".$item[Slot]]."' AND Char_id='".$stat[id]."'");
		}
		mysql_query("UPDATE users SET `eq_".$item[Slot]."`='".$user_item[id]."' WHERE `id`='".$stat[id]."'");
		mysql_query("UPDATE user_Items SET `Equiped`='yes' WHERE id='".$user_item[id]."' AND Char_id='".$stat[id]."'");
	}
	
	echo "<form method=post action=index.php><table border=\"0\" style=\"border:solid,1px;border-color:#666666;\" cellspacing=\"0\" cellpadding=\"0\">
	  <tr>
	  <td colspan=\"5\" style=\"height:22px;width:100%;background-image:url(images/bp_menu.jpg);\" align=\"center\">
	  <img src=\"images/bp_reg.jpg\">
	  <img src=\"images/bp_quest.jpg\">
	  <img src=\"images/bp_key.jpg\">  
	  </td>
	  </tr>
	  <tr>
	  ";
	$type="Regular";
	$tcount = 0;
	$trcount = 0;
	$bpslots = $stat[Backpack_slots];
	$Items = mysql_query("SELECT * FROM user_Items WHERE Char_id='".$stat[id]."' and Equiped='no'");
	while($user_Item = mysql_fetch_array($Items)) 
	{
		if($tcount < $bpslots)
		{
		$Item =  mysql_fetch_array(mysql_query("SELECT * FROM Item_db WHERE id='".$user_Item[Item_id]."' and type='".$type."' Limit 1"));
		$trcount++;
		$tcount++;
		if($trcount > 5)
		{
			$trcount = 1;
			echo "  </tr>
			  <tr>";
		}
			echo "<td style=\"width:50px;height:50px;background-image:URL(images/I_cont.jpg);\" align=\"center\" valign=\"center\">
			
			   <table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" height=\"45\" width=\"45\">
				<tr>
				 <td align=\"center\" valign=\"middle\" style=\"font-size:9px;padding:2px;border: 0px solid;\">
				  <div style=\"\" id=\"Item_".$user_Item[id]."\" onClick=\"MakeMenu(event,".$user_Item[id].",".$Item[Action_activate].",".$Item[Action_equip].",".$Item[Action_vault].",".$Item[Action_cvault].",".$Item[Action_sell].",".$Item[Action_drop].")\" onMouseover=\"ajaxtooltip('".$user_Item[Item_id]."', this, event)\" onMouseout=\"delayhidetip()\" style=\"position:relative;\">
				   <img width=\"40\" height=\"40\" src=\"".$Item[Image]."\" style=\"border: 0px solid;\">
				   <input id=\"Drop_".$user_Item[id]."\" type=checkbox style=\"display:none\" name=\"drop[]\" value=\"".$user_Item[id]."\">
				   <input id=\"Cvault_".$user_Item[id]."\" type=checkbox style=\"display:none\" name=\"Cvault[]\" value=\"".$user_Item[id]."\">
				  </div>
				 </td>
				</tr>
			   </table>
			   
									
				  </td>
			";
		}
	}
	while($tcount < $bpslots) 
	{
		$trcount++;
		$tcount++;
		if($trcount > 5)
		{
			$trcount = 1;
			echo "  </tr>
			  <tr>";
		}
		echo "<td style=\"width:50px;height:50px;background-image:URL(images/I_cont.jpg);\" align=\"center\" valign=\"center\">
		 
			</td>
			";
	}
	
	  
	echo "</tr><td colspan=\"5\" Align=center>
	<div id=\"sec_id\" style=\"display:none;font-size:11px;\"><font color=\"white\">
	".$account[sec_question]."</font><br>
	<input type=\"password\" style=\"border : none; font-family : Verdana; color : white; background : #200000;\" name=\"sec_pass\"><br>
	<input type=\"submit\" value=\"Submit\" style=\"border: 1px solid #200000;\">
	</div>
	</td></tr></table></form>";
?>