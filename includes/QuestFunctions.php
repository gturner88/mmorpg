<?php

function QuestStep($Uid, $Quest_id)
{
	$Step = mysql_fetch_array(mysql_query("SELECT * FROM user_Quest WHERE Quest_id='".$Quest_id."' AND Char_id='".$Uid."' LIMIT 1"));
	if($Step[Completed] == "yes") return "Completed";
	elseif(isset($Step[Step])) return $Step[Step];
	else return 0;
}

function isCurStep($Uid, $mob_id)
{
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Steps` WHERE Mob_id='".$mob_id."'");
	while($mobQuests = mysql_fetch_array($Quest_sql))
	{
		$Quest_Step = QuestStep($Uid, $mobQuests[Quest_id]);
		if($mobQuests[Step_id] == $Quest_Step || $Quest_Step == 0) if(checkComplete($Uid, $mobQuests[Quest_id]) == false) return true;
	}
	return false;	
}

function checkComplete($Uid, $Quest_id)
{
	$Step = mysql_fetch_array(mysql_query("SELECT * FROM user_Quest WHERE Quest_id='".$Quest_id."' AND Char_id='".$Uid."' LIMIT 1"));
	if($Step[Completed] == "yes") return true;
	else return false;
}

function isCurQuestsStep($mob_id, $Uid, $mobQuests)
{
		$QuestStep = QuestStep($Uid, $mobQuests[Quest_id]);
		if($mobQuests[Step_id] == $QuestStep || $QuestStep == 0 && $mobQuests[Step_id] == 1) 
		{
			if($QuestStep == 0 && $mobQuests[Step_id] == 1)
			{
				setUserTask($mobQuests[Quest_id], $mobQuests[Step_id], $Uid);
				mysql_query("INSERT INTO `user_Quest` (`Char_id`, `Quest_id`) VALUES('".$Uid."', '".$mobQuests[Quest_id]."')");				
			}
			return true;
		}
		else return false;	
}

function isNextQuestsStep($mob_id, $Uid, $mobQuests)
{
		if($mobQuests[Step_id] == (QuestStep($Uid, $mobQuests[Quest_id]) + 1)) return true;
		else return false;	
}

function mobQuests($mob_id)
{
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Steps` WHERE Mob_id='".$mob_id."'");
	return $Quest_sql;
}


function curQuests($Uid, $mob_id)
{
	$mob_Quests = mobQuests($mob_id);
	$quests = array();
	while($mobQuest = mysql_fetch_array($mob_Quests))
	{
		if(checkComplete($Uid, $mobQuest[Quest_id]) == false)
			if(isCurQuestsStep($mob_id, $Uid, $mobQuest) == true)
				array_push($quests, $mobQuest);
	}
	return $quests;
}

function Quest_Info($Quest_id, $Step_id)
{
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Steps` WHERE Quest_id='".$Quest_id."' AND Step_id='".$Step_id."' LIMIT 1");
	return mysql_fetch_array($Quest_sql);
}

function setUserTask($Quest_id, $Step_id, $Uid)
{
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Tasks` WHERE `Quest_id`='".$Quest_id."' AND `Step_id`='".$Step_id."' AND `Type`='Kill'");
	if(mysql_num_rows($Quest_sql) < 1) return false;
	while($Task = mysql_fetch_array($Quest_sql))
	{
		mysql_query("INSERT INTO `user_Quest_Task` (`Char_id`, `Quest_id`, `Step_id`, `Task_id`, `Mob_id`) VALUES('".$Uid."', '".$Quest_id."', '".$Step_id."', '".$Task[Task_id]."', '".$Task[Action]."')");
	}
}

function removeUserTask($Quest_id, $Step_id, $Uid)
{
	mysql_query("DELETE FROM `user_Quest_Task` WHERE `Char_id`='".$Uid."' AND `Quest_id`='".$Quest_id."'");
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Tasks` WHERE `Quest_id`='".$Quest_id."' AND `Step_id`='".$Step_id."' AND `Type`='Collect'");
	if(mysql_num_rows($Quest_sql) < 1) return false;
	while($Task = mysql_fetch_array($Quest_sql))
	{
		$Collect_Info = getUserCollect($Task[Task_id], $Quest_id, $Step_id);
		mysql_query("UPDATE user_Items set Equiped='Deleted' WHERE Item_id='".$Collect_Info."' AND Equiped='no' LIMIT ".$Task[Amount]."");
	}
}

function getUserTaskInfo($Quest_id, $Step_id, $Task_id, $Uid)
{
	$Task_sql = mysql_query("SELECT * FROM `user_Quest_Task` WHERE `Quest_id`='".$Quest_id."' AND `Step_id`='".$Step_id."' AND `Task_id`='".$Task_id."' AND `Char_id`='".$Uid."'");
	$count = mysql_num_rows($Task_sql);
	if($count > 0) return mysql_fetch_array($Task_sql);
	else return false;
}

function getUserCollect($Task_id, $Quest_id, $Step_id)
{
	$Task_sql = mysql_query("SELECT * FROM `Quest_Items` WHERE `Task_id`='".$Task_id."' AND Quest_id='".$Quest_id."' AND Step_id='".$Step_id."'");
	$count = mysql_num_rows($Task_sql);
	$Task_sql = mysql_fetch_array($Task_sql);
	if($count > 0) return $Task_sql[Item_id];
	else return false;
}

function getMobName($id)
{
	$mob = mysql_fetch_array(mysql_query("SELECT * FROM `mobs` WHERE `id`='".$id."'"));
	return $mob[Name];
}

function getItemName($id)
{
	$item = mysql_fetch_array(mysql_query("SELECT * FROM `Item_db` WHERE `id`='".$id."'"));
	return $item[Name];
}

function TaskInfo($Quest_id, $Step_id, $Uid)
{
	$Tasks = array();
	$count = 0;
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Tasks` WHERE `Quest_id`='".$Quest_id."' AND `Step_id`='".$Step_id."'");
	if(mysql_num_rows($Quest_sql) < 1) return false;
	while($Task = mysql_fetch_array($Quest_sql))
	{
		if($Task[Type] == "Kill")
		{
			if(($user_Task = getUserTaskInfo($Task[Quest_id], $Task[Step_id], $Task[Task_id], $Uid)) != false){
				if($user_Task[Amount] >= $Task[Amount]) { $Completed = true; $user_Task[Amount] = $Task[Amount]; } else $Completed = false;
				array_push($Tasks, array("Amount" => $user_Task[Amount],  "Total_Amount" => $Task[Amount], "Completed" => $Completed, "Name" => getMobName($user_Task[Mob_id]), "Type" => "Killed"));
				$count++;
			}
		}
		else
		{
			if(($Item_id = getUserCollect($Task[Task_id],$Quest_id, $Step_id)) != false){
				$user_Amount = mysql_num_rows(mysql_query("SELECT * FROM `user_Items` WHERE `Item_id`='".$Item_id."' AND `Char_id`='".$Uid."' AND Equiped <> 'Deleted'"));
				if($user_Amount >= $Task[Amount]) { $Completed = true; $user_Amount = $Task[Amount]; } else $Completed = false;
				array_push($Tasks, array("Amount" => $user_Amount,  "Total_Amount" => $Task[Amount], "Completed" => $Completed, "Name" => getItemName($Item_id), "Type" => "Collected"));
				$count++;
			}
		}
	}
	if($count > 0) return $Tasks;
	else return false;
}

function mobTaskInfo($mob_id, $Uid)
{
	$Tasks = array();
	$count = 0;
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Tasks` WHERE `Action`='".$mob_id."' AND `Type`='Kill'");
	if(mysql_num_rows($Quest_sql) < 1) return false;
	while($Task = mysql_fetch_array($Quest_sql))
	{
		$user_Task = getUserTaskInfo($Task[Quest_id], $Task[Step_id], $Task[Task_id], $Uid);
		if($user_Task != false){
			if($user_Task[Amount] >= $Task[Amount]) { $Completed = true; $user_Task[Amount] = $Task[Amount]; } else $Completed = false;
			array_push($Tasks, array("Amount" => $user_Task[Amount],  "Total_Amount" => $Task[Amount], "Completed" => $Completed, "Name" => getMobName($user_Task[Mob_id]), "Type" => "Killed"));
			$count++;
		}
	}
	if($count > 0) return $Tasks;
	else return false;
}

function StepCompleted($Quest_id, $Step_id, $Uid)
{
	$Tasks = array();
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Tasks` WHERE `Quest_id`='".$Quest_id."' AND `Step_id`='".$Step_id."'");
	if(mysql_num_rows($Quest_sql) < 1) return true;
	while($Task = mysql_fetch_array($Quest_sql))
	{
		if($Task[Type] == "Kill")
		{
			$user_Task = getUserTaskInfo($Task[Quest_id], $Task[Step_id], $Task[Task_id], $Uid);
			if($user_Task[Amount] < $Task[Amount]) return false;
		}
		else
		{
			$Item_id = getUserCollect($Task[Task_id], $Quest_id, $Step_id);
			$user_Amount = mysql_num_rows(mysql_query("SELECT * FROM `user_Items` WHERE `Item_id`='".$Item_id."' AND `Char_id`='".$Uid."' AND Equiped='no'"));
			if($user_Amount < $Task[Amount]) return false;
		}
	}
	
	return true;
}

function RewardQuestItems($Quest_id, $Step_id, $Uid)
{
	$EXPRewards = 0;
	$Quest_sql = mysql_query("SELECT * FROM `Quest_Rewards` WHERE `Quest_id`='".$Quest_id."' AND `Step_id`='".$Step_id."'");
	while($Rewards = mysql_fetch_array($Quest_sql))
	{
		if($Rewards[Type] == "EXP")
		{
			mysql_query("UPDATE users SET exp=exp+".$Rewards[Amount]." WHERE id='".$Uid."'");
			$EXPRewards += $Rewards[Amount];
		}
		elseif($Rewards[Type] == "Item") 
		{
			mysql_query("INSERT INTO `user_Items` (Item_id, Char_id) VALUES('".$Rewards[Amount]."', '".$Uid."')");
			$Final_Rewards .= "You have been awarded a ".getItemName($Rewards[Amount])."<br />";
		}		
	}
	if($EXPRewards > 0) $Final_Rewards .= "You have been awarded ".add_commas($EXPRewards)." EXP<br />";
	return $Final_Rewards."<br />";
}

function Next_Step($Quest_id, $Step_id, $Uid)
{
	$Quest_info = Quest_Info($Quest_id, $Step_id);
	$Next_Quest_info = Quest_Info($Quest_id, $Step_id + 1);
	removeUserTask($Quest_id, $Step_id, $Uid);
	if($Next_Quest_info["Final"] == "yes")
	{
		$Quest = mysql_fetch_array(mysql_query("SELECT * FROM `Quests` WHERE id='".$Quest_id."'"));
		if($Quest[Repeatable] == "yes")
		{
			mysql_query("DELETE FROM `user_Quest` WHERE `Quest_id`='".$Quest_id."' AND `Char_id`='".$Uid."' LIMIT 1");
		}
		else
		{
			mysql_query("UPDATE `user_Quest` set Completed='yes', Step=Step+1 WHERE `Quest_id`='".$Quest_id."' AND `Char_id`='".$Uid."' LIMIT 1");
		}
	}
	else
	{
		mysql_query("UPDATE `user_Quest` set Step=Step+1 WHERE `Quest_id`='".$Quest_id."' AND `Char_id`='".$Uid."' LIMIT 1");
		setUserTask($Quest_id, $Step_id + 1, $Uid);
	}
}



?>