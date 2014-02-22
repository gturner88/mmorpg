<?php 
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	$noheader = true;
	
	include("includes/Header.php"); //includes header
	
	$remove = $_GET[remove];
	if($remove)
	{
		$user_item = mysql_fetch_array(mysql_query("Select * FROM user_Items WHERE id='".$remove."' AND Char_id='".$stat[id]."' LIMIT 1"));
		$item = mysql_fetch_array(mysql_query("Select * FROM Item_db WHERE id='".$user_item[Item_id]."'"));
		mysql_query("UPDATE users SET `eq_".$item[Slot]."`='0' WHERE `id`='".$stat[id]."'");
		mysql_query("UPDATE user_Items SET `Equiped`='no' WHERE id='".$user_item[id]."' AND Char_id='".$stat[id]."'");
	}
	echo "<div style=\"position:relative; width:300px; height:385px; background-Image:URL(/images/equipment-bg.jpg);\">";
	$user_head = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Head]."' Limit 1"));
	$head = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_head[Item_id]."'"));
	
	$user_neck = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Neck]."' Limit 1"));
	$neck = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_neck[Item_id]."'"));
	
	$user_weapon = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Weapon]."' Limit 1"));
	$weapon = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_weapon[Item_id]."'"));
	
	$user_chest = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Chest]."' Limit 1"));
	$chest = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_chest[Item_id]."'"));
	
	$user_shield = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Shield]."' Limit 1"));
	$shield = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_shield[Item_id]."'"));
	
	$user_belt = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Belt]."' Limit 1"));
	$belt = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_belt[Item_id]."'"));
	
	$user_legs = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Legs]."' Limit 1"));
	$legs = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_legs[Item_id]."'"));
	
	$user_ring = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Ring]."' Limit 1"));
	$ring = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_ring[Item_id]."'"));
	
	$user_boots = mysql_fetch_array(mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes' AND id='".$stat[eq_Boots]."' Limit 1"));
	$boots = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_boots[Item_id]."'"));
	
			///Head
			echo "<div style=\"position:absolute; left:118px; top:7px; width:62px; height:46px;text-align:center\">";
			if($user_head[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$head[Image]."\" onMouseover=\"ajaxtooltip('".$head[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_head[id].")\">";	
		}
		echo "</div>";
		
		///Neck
		echo "<div style=\"position:absolute; left:197px; top:12px; width:41px; height:41px;text-align:center\">";
			if($user_neck[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$neck[Image]."\" onMouseover=\"ajaxtooltip('".$neck[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_neck[id].")\">";	
		}
		echo "</div>";
		///Weapon
		echo "<div style=\"position:absolute; left:45px; top:67px; width:56px; height:96px;text-align:center\">";
			if($user_weapon[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$weapon[Image]."\" onMouseover=\"ajaxtooltip('".$weapon[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_weapon[id].")\">";	
		}
		echo "</div>";
			///Chest
		echo "<div style=\"position:absolute; left:121px; top:67px; width:56px; height:96px;text-align:center\">";
			if($user_chest[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$chest[Image]."\" onMouseover=\"ajaxtooltip('".$chest[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_chest[id].")\">";	
		}
		echo "</div>";
		///Shield
		echo "<div style=\"position:absolute; left:198px; top:67px; width:56px; height:96px;text-align:center\">";
			if($user_shield[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$shield[Image]."\" onMouseover=\"ajaxtooltip('".$shield[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_shield[id].")\">";	
		}
		echo "</div>";
		///pants
		echo "<div style=\"position:absolute; left:118px; top:175px; width:62px; height:75px;text-align:center\">";
		 if($user_legs[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$legs[Image]."\" onMouseover=\"ajaxtooltip('".$legs[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_legs[id].")\">";	
		}
		echo "</div>";
		///belt	
		echo "<div style=\"position:absolute; left:61px; top:192px; width:41px; height:41px;text-align:center\">";
			if($user_belt[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$belt[Image]."\" onMouseover=\"ajaxtooltip('".$belt[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_belt[id].")\">";	
		}
		echo "</div>";
		///ring
		echo "<div style=\"position:absolute; left:197px; top:192px; width:41px; height:41px;text-align:center\">";
			if($user_ring[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$ring[Image]."\" onMouseover=\"ajaxtooltip('".$ring[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_ring[id].")\">";	
		}
		echo "</div>";
		///legs
		echo "<div style=\"position:absolute; left:118px; top:262px; width:62px; height:66px;text-align:center\">";
			if($user_boots[Char_id] == $stat[id])
			{
			echo "<img style=\"border:0px;\" src=\"".$boots[Image]."\" onMouseover=\"ajaxtooltip('".$boots[id]."', this, event)\" onMouseout=\"delayhidetip()\" onclick=\"removeItem(".$user_boots[id].")\">";	
		}
		echo "</div>";
	echo "</div>";
?>