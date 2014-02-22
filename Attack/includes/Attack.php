<?php
$type="Player";
$mob = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='".$id."'"));
if(!isset($mob[id])) {
echo 'Invalid Player ID';
exit;
}
$mob_spawn = mysql_num_rows(mysql_query("SELECT * FROM user_Attack WHERE Time_back>".$ctime." AND Defender_id=".$mob[id]." AND Attacker_id='".$stat[id]."' AND Type='Player' Limit 1"));
if($mob_spawn == 1)
{
echo 'This Player has is already been killed in the last hour!';
exit;
}
$attack_num = 0;
$your_atk = $stat[attack];
$your_hp = $stat[hitpoints];
$mob_atk = $mob[attack];
$mob_hp = $mob[hitpoints];
$stamina = 50;
mysql_query("UPDATE `Personal_hitlist` SET Times_hit=Times_hit+1 WHERE `Hit_id`='".$mob[id]."'");
mysql_query("UPDATE `Crew_hitlist` SET Times_hit=Times_hit+1 WHERE `Hit_id`='".$mob[id]."'");
mysql_query("UPDATE users SET stamina=stamina-".$stamina." WHERE id='".$stat[id]."'");
mysql_query("INSERT INTO user_Attack (`Defender_id`,`Attacker_id`,`Defender_Hp`,`Attacker_Hp`)VALUES('".$mob[id]."','".$stat[id]."','".$mob_hp."','".$your_hp."')");
$C_Attack = mysql_fetch_array(mysql_query("SELECT * FROM user_Attack WHERE id=LAST_INSERT_ID() AND Attacker_id='".$stat[id]."' AND Defender_id='".$mob[id]."' AND Type='Player'"));
while($your_hp > 0 && $mob_hp > 0)
{
$critical = 1;
$attack_num = $attack_num + 1;
$att_block = "no";
$att_crit = "no";
$def_block = "no";
$def_crit = "no";
$att_crit_chance = rand(1,100);
$att_block_chance = rand(1,100);
$def_crit_chance = rand(1,100);
$def_block_chance = rand(1,100);
if($att_crit_chance < $stat[critical]){$critical = 1+(rand(1,5)/10); $att_crit = "yes";}
$norm_hit=$your_atk*(1+(1/rand(1,rand(50,100))));
$your_hit=$norm_hit*$critical;
$your_hit=round($your_hit);
if($def_block_chance < $mob[block]){$def_block = "yes"; $your_hit = 0;}
$mob_hp = $mob_hp - $your_hit;

mysql_query("INSERT INTO user_Attack_log (`Attack_id`,`Attacker`,`Attack_num`,`Amount_hit`,`Attacker_critical`,`Attacker_block`)VALUES('".$C_Attack[id]."','attacker','".$attack_num."','".$your_hit."','".$att_crit."','".$def_block."')");
if($mob_hp > 0)
{
$critical = 1;
if($def_crit_chance < $mob[critical]){$critical = 1+(rand(1,5)/10); $att_crit = "yes";}
$attack_num = $attack_num + 1;
$mob_hit=$mob_atk*(1+(1/rand(1,rand(50,100))));
$mob_hit=$mob_hit*$critical;
$mob_hit=round($mob_hit);
if($att_block_chance < $stat[block]){$att_block = "yes"; $mob_hit = 0;}
$your_hp -= $mob_hit;


mysql_query("INSERT INTO user_Attack_log (`Attack_id`,`Attacker`,`Attack_num`,`Amount_hit`,`Attacker_block`,`Attacker_critical`)VALUES('".$C_Attack[id]."','defender','".$attack_num."','".$mob_hit."','".$att_block."','".$def_crit."')");


if($your_hp < 1)
{
$win = "no";
$extras = "";
}
}
else
{
$win = "yes";
if($mob[level] > $stat[level] - 20)
{
	$expgain = $stamina*(1+($stamina/50))*(1+(1/rand(1,rand(50,100))))*(($mob[level]/100));
	$expgain = $expgain*(1+(rand(20,45)/10));	
	$expgain = round($expgain);
	$explost = $stamina*(1+($stamina/50))*(1+(1/rand(1,rand(50,100))))*(($mob[level]/100));
	$explost = $explost*(1+(rand(50,75)/10));
	$explost = round($explost);
	$extras = $stat[name]." Has Gained ".$expgain." EXP!<br>";
	$extras = $extras.$mob[name]." Has Lost ".$explost." EXP!<br>";
}
else
{
	$extras = $stat[name]." has taken pity on ".$mob[name]."!";
}
}
}
$thetime = $ctime + (60*60);
mysql_query("UPDATE users SET exp=exp+".$expgain." WHERE id='".$stat[id]."'");
mysql_query("UPDATE users SET exp=exp-".$explost." WHERE id='".$mob[id]."'");
mysql_query("UPDATE `Personal_hitlist` SET exp_Striped=exp_Striped+".$explost." WHERE `Hit_id`='".$mob[id]."'");
mysql_query("UPDATE `Crew_hitlist` SET exp_Striped=exp_Striped+".$explost." WHERE `Hit_id`='".$mob[id]."'");
mysql_query("UPDATE user_Attack SET Time_back='".$thetime."', Win='".$win."', Extra='".$extras."' WHERE id='".$C_Attack[id]."'");
$id = $C_Attack[id];
?>
