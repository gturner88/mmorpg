<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Mob Talk"; //title of document
	$isLoggedIn = true;
	$json = $_GET['json'];
	
	if($json) $noheader = true;
	
	include("includes/Header.php"); //includes header
	include("includes/QuestFunctions.php"); //includes header
	
	$id = $_GET['id'];
	$mob_room = mysql_fetch_array(mysql_query("SELECT * FROM `mob_Rooms` WHERE `id`='".$id."'"));
	if($stat[C_Room] != $mob_room[room_id])
	{
		echo "You do not see that mob around here!";
		exit;
	}
	
	$mob = mysql_fetch_array(mysql_query("SELECT * FROM `mobs` WHERE `id`='".$mob_room[mob_id]."'"));
	
	echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\" width=\"550px\" height=\"100%\">
	<tr><td colspan=\"2\" align=\"center\" style=\"background-color:#222;color:#CCC;\">
		".$mob[Name]."
	</td></tr>
	<tr><td valign=\"top\" align=\"left\" width=\"100%\">";
	$Quest_id = $_GET[questid];
	$Step_id= $_GET[stepid];
	
	if($Quest_id != "" && $Step_id != "")
	{
		$Step_Info = Quest_Info($Quest_id, $Step_id);
		if(isNextQuestsStep($id, $stat[id], $Step_Info))
		{
			if(StepCompleted($Quest_id, $Step_id - 1, $stat[id])) 
			{
				$Rewards = RewardQuestItems($Quest_id, $Step_id - 1, $stat[id]);
				Next_Step($Quest_id, $Step_id - 1, $stat[id]);
				echo $Rewards;
			}
		}
		$curQuestStep = isCurQuestsStep($id, $stat[id], $Step_Info);
		if($curQuestStep)
		{
			$Next_Step_info = Quest_Info($Quest_id, $Step_id + 1, $id);
			echo $Step_Info[Talk_info];
			echo "<br /><br />";
			$Tasks_Info = TaskInfo($Quest_id, $Step_id, $stat[id]);
			if($Tasks_Info != false) 
			{
				foreach($Tasks_Info as $Task_Info)
				{
					if($Task_Info[Completed] == true) $color = "#00FF00"; else $color="#FF0000";
					echo "<div style=\"color:".$color.";\">".add_commas($Task_Info[Amount])."/".add_commas($Task_Info[Total_Amount])." ".$Task_Info[Name]."&#39;s ".$Task_Info[Type]."</div>";
				}
			}
			echo "<br /><br />";
			if(StepCompleted($Quest_id, $Step_id, $stat[id])) echo "<a href=\"Mobtalk.php?id=".$id."&json=".$json."&questid=".$Next_Step_info[Quest_id]."&stepid=".$Next_Step_info[Step_id]."\">".$Next_Step_info[Link_info]."</a><br>";
		}
		else
		{
			if(checkComplete($stat[id], $Quest_id) == true)
			{
				echo $Step_Info[Talk_info];
			}
			else
			{
				echo "You are not on this step yet.";
			}
		}
	}
	else {	
		foreach(curQuests($stat[id], $id) as $quest)
		{
			echo "<a href=\"Mobtalk.php?id=".$id."&json=".$json."&questid=".$quest[Quest_id]."&stepid=".$quest[Step_id]."\">".$quest[Link_info]."</a><br>";
		}
	}
	
	echo "<br /><br />";	
	if($json == "") echo "<a href=\"world.php\">Sneak Away</a>";
	else  echo "<a href=\"javascript:parent.closeattack()\">Sneak Away</a>";
	
	echo "</td><td align=\"Right\" valign=\"top\"><img src=\"".$mob[Image]."\"></td></tr>
	</table>";
	
	if($json == "") include("includes/Footer.php"); 
?>
