<?php

	$type="Mob";
	$themob = mysql_fetch_array(mysql_query("SELECT * FROM mob_Rooms WHERE id='".$id."'"));
	$mob = mysql_fetch_array(mysql_query("SELECT * FROM mobs WHERE id='".$themob[mob_id]."'"));
	include("../includes/QuestFunctions.php");
	if(!isset($themob[id])) {
		
		echo 'Invalid Mob';
		exit;
		
	}
	if($themob[room_id] != $stat[C_Room])
	{
		
		echo 'You are not in the same room as that mob!';
		exit;
		
	}
	$mob_spawn = mysql_num_rows(mysql_query("SELECT * FROM user_Attack WHERE Time_back>".$ctime." AND Win='yes' AND Defender_id='".$themob[id]."' AND Attacker_id='".$stat[id]."' AND Type='Mob' Limit 1"));
	if($mob_spawn == 1)
	{
		
		echo 'This mob has already died!';
		exit;
		
	}
	if($mob[Quest_only] == 'yes' || !is_numeric($id))
	{
		
		echo 'Hacking Attempt This mob is not Attackable!';
		exit;
		
	}
	
	$attack_num = 0;
	$your_atk = $stat[attack];
	$your_hp = $stat[hitpoints];
	$mob_atk = $mob[Attack];
	$mob_hp = $mob[Hp];
	$tempstamina = $stat[stamina]-$mob[Stamina];
	
	mysql_query("UPDATE users SET stamina=stamina-".$mob[Stamina]." WHERE id='".$stat[id]."'");
	mysql_query("INSERT INTO user_Attack (`Defender_id`,`Attacker_id`, `Defender_Hp`,`Attacker_Hp`, `Type`, `Unread`)VALUES('".$themob[id]."','".$stat[id]."','".$mob_hp."','".$your_hp."', 'Mob', 'no')");
	
	$C_Attack = mysql_fetch_array(mysql_query("SELECT * FROM user_Attack WHERE Attacker_id='".$stat[id]."' AND Defender_id='".$themob[id]."' AND Type='Mob' ORDER BY id DESC LIMIT 1"));
	
	while($your_hp > 0 && $mob_hp > 0)
	{
		$attack_num = $attack_num + 1;
		$block = "no";
		$crit = "no";
		$crit_chance = rand(1,100);
		$block_chance = rand(1,100);
		$critical = 1;
		
		if($crit_chance < $stat[critical]){$critical = 1+(rand(1,5)/10); $crit = "yes";}
		
		$norm_hit=($your_atk*100)*(1+(1/rand(1,rand(50,100))));
		$your_hit=$norm_hit*$critical/100;
		$your_hit=round($your_hit);
		$mob_hp -= $your_hit;
		mysql_query("INSERT INTO user_Attack_log (`Attack_id`,`Attacker`,`Attack_num`,`Amount_hit`,`Attacker_critical`)VALUES('".$C_Attack[id]."','attacker','".$attack_num."','".$your_hit."','".$crit."')");
		if($mob_hp > 0)
		{
			$attack_num = $attack_num + 1;
			$mob_hit=(($mob_atk*100)*(1+(1/rand(1,rand(50,100)))))/100;
			$mob_hit=round($mob_hit);
			
			if($block_chance < $stat[block]){$block = "yes"; $mob_hit = 0;}
			
			$your_hp -= $mob_hit;
			
			mysql_query("INSERT INTO user_Attack_log (`Attack_id`,`Attacker`,`Attack_num`,`Amount_hit`,`Attacker_block`)VALUES('".$C_Attack[id]."','defender','".$attack_num."','".$mob_hit."','".$block."')");
			
			if($your_hp < 1)
			{
				$win = "no";
				$extras = "";
			}
			
		}
		else
		{
			if($win != "no")
			{
				$win = "yes";
				$expgain = $mob[Level]*(1+(1/rand(1,rand(50,100))));
				$expgain = $expgain*(1+(rand(-5,5)/10));
				$expgain = round($expgain);
				
				$Quest_Items = mysql_query("SELECT * FROM Quest_Items WHERE mob_id='".$mob[id]."'");				
				while($Quest_Item = mysql_fetch_array($Quest_Items))
				{
					$Quest_sql = mysql_query("SELECT * FROM `user_Quest` WHERE Quest_id='".$Quest_Item[Quest_id]."' AND Step='".$Quest_Item[Step_id]."' AND Char_id='".$stat[id]."'");
					$questcount = mysql_num_rows($Quest_sql);
					if($questcount > 0)
					{
						$ItemDrop = rand(0,1000);
						$droprate = $Quest_Item[Drop_Rate] * 10;
						if($ItemDrop <= $droprate)
						{
							$extras .= $stat[name]." Has Found a ".getItemName($Quest_Item[Item_id])."<br />";
							mysql_query("INSERT INTO `user_Items` (Item_id, Char_id) VALUES ('".$Quest_Item[Item_id]."', '".$stat[id]."')");
						}
					}
				}
				
				//This is the drop item sequence...
				//Common 0-500
				//Un-Common 501-750
				//Magical 751-850
				//Rare 851-875
				//Elite 876-890
				//Kingly 890-900
				//God!901-905
				//Nothing 906-1000
				
				$ItemDrop = rand(0,1000);
				$ItemRarity = "None";
				if($itemDrop <= 500) $ItemRarity = "Common";
				elseif($itemDrop <= 750) $ItemRarity = "Un-Common";
				elseif($itemDrop <= 850) $ItemRarity = "Magical";
				elseif($itemDrop <= 875) $ItemRarity = "Rare";
				elseif($itemDrop <= 890) $ItemRarity = "Elite";
				elseif($itemDrop <= 900) $ItemRarity = "Kingly";
				elseif($itemDrop <= 906) $ItemRarity = "God!";
				
				$mobItems = mysql_fetch_array(mysql_query("SELECT * FROM `mob_Items` WHERE mob_id='".$themob[id]."' AND rarity='".$ItemRarity."' ORDER BY RAND() LIMIT 1"));
				$mobItemsnum = mysql_num_rows(mysql_query("SELECT * FROM `mob_Items` WHERE mob_id='".$themob[id]."' AND rarity='".$ItemRarity."'"));
				
				//javaAlert($mobItemsnum);
				
				if($mobItemsnum > 0)
				{
					$mobitem = mysql_fetch_array(mysql_query("Select * FROM Item_db WHERE id='".$mobItems[item_id]."'"));
					$extras .= $stat[name]." Has Found ".$mobitem[Name]."<br />";
					mysql_query("INSERT INTO `user_Items` (Item_id, Char_id, Timer, Time_Left) VALUES ('".$mobItems[item_id]."', '".$stat[id]."', '".$mobItems[timer]."', '".$mobItems[time_left]."')");
				}
				
				$extras .= $stat[name]." Has Gained ".$expgain." EXP!";
				mysql_query("UPDATE user_Quest_Task SET Amount=Amount+1 WHERE Mob_id='".$mob[id]."' AND Char_id='".$stat[id]."'");
				$Tasks_Info = mobTaskInfo($mob[id], $stat[id]);
				if($Tasks_Info != false) 
				{					
					foreach($Tasks_Info as $Task_Info)
					{
						if($Task_Info[Completed] == true) $color = "#00FF00"; else $color="#FF0000";
						$extras .= "<div style=color:".$color.";>".add_commas($Task_Info[Amount])."/".add_commas($Task_Info[Total_Amount])." ".$Task_Info[Name]."&#39;s ".$Task_Info[Type]."</div>";
					}
				}
				
			}
			else
			{
				$extras .= $stat[name]." Has Been Defeated!";
			}
			
		}
	}
	
	Secure($extras);
	
	$thetime = $ctime + $mob[Spawn_time];
	mysql_query("UPDATE users SET exp=exp+".$expgain." WHERE id='".$stat[id]."'");
	mysql_query("UPDATE user_Attack SET Time_back='".$thetime."', Win='".$win."', Extra='".$extras."' WHERE id='".$C_Attack[id]."'");
	$id = $C_Attack[id];
	
?>