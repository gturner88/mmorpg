<?php

	$Items = mysql_query("Select * From user_Items WHERE Char_id='".$stat[id]."' AND Equiped='yes'");
	
	$Level = mysql_fetch_array(mysql_query("SELECT * FROM ".$maindb.".Level WHERE `level`='".$stat[level]."'"));
	
	$spt = 200;
	$max_stamina = 2000;
	$block = 0;
	$ept = 0;
	$critical = 0;
	$atk = $Level[attack];
	$hp = $Level[hitpoints];
	
	while($user_Item = mysql_fetch_array($Items))
	{
		$Item = mysql_fetch_array(mysql_query("Select * From Item_db WHERE id='".$user_Item[Item_id]."'"));
		$atk += $Item[attack];
		$hp += $Item[hitpoints];
		$spt += $Item[spt];
		$ept += $Item[ept];
		$max_stamina += $Item[max_stamina];
		$block += $Item[block];
		$critical += $Item[critical];
	}
	if($stat[exp] < $Level[exp]) mysql_query("UPDATE `users` SET `exp`='".$Level[exp]."' WHERE `id`='".$stat[id]."'");
	if($block > 45) $block = 45;
	if($critical > 100) $critical = 100;
	
	///The update
	mysql_query("UPDATE `users` SET `attack` =  '".$atk."', `block` =  '".$block."', `critical` =  '".$critical."', `spt` =  '".$spt."', `max_stamina` =  '".$max_stamina."', `ept` =  '".$ept."', `hitpoints` = '".$hp."' WHERE `id` =".$stat[id]."");

?>