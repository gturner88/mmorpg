<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	$noheader=true;
	
	include("includes/Header.php"); //includes header
	
	$id = $_GET['id'];
	$mob_id = $_GET['mob_id'];
	$player_id = $_GET['player_id'];
	
	if(isset($mob_id) && isset($player_id))
	{
		echo "You cant attack 2 things at once!";
		exit;
	}
	
	if(isset($mob_id)) { $id = $mob_id; include("includes/MobAttack.php"); }
	elseif(isset($player_id)) { $id = $player_id; include("includes/Attack.php"); }
	
	
	
	$Attack = mysql_fetch_array(mysql_query("SELECT * FROM user_Attack WHERE id='".$id."'"));
	$type = $Attack['Type'];
	
	$player = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='".$Attack['Attacker_id']."'"));
	$Attacker_name = $player['name'];
	$Attacker_pic = "/profile/".$Attack['Attacker_id'].".gif";
	
	if($type == "Player")
	{
		$player = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='".$Attack['Defender_id']."'"));
		$Defender_name = $player['name'];
		$Defender_pic = "/profile/".$Attack['Defender_id'].".gif";	
	}
	elseif($type == "Mob")
	{
		$themob = mysql_fetch_array(mysql_query("SELECT * FROM mob_Rooms WHERE id='".$Attack['Defender_id']."'"));
	    $mob = mysql_fetch_array(mysql_query("SELECT * FROM mobs WHERE id='".$themob[mob_id]."'"));
		$Defender_name = $mob['Name'];
		$Defender_pic = $mob['Image'];	
	}
	
	$Total_Rounds = mysql_num_rows(mysql_query("SELECT * FROM user_Attack_log WHERE Attack_id='".$Attack['id']."'"));
	$Total_Rounds = ceil($Total_Rounds / 2);
	$Attacker_hits = mysql_query("SELECT * FROM user_Attack_log WHERE Attack_id='".$Attack['id']."' AND Attacker='attacker' ORDER BY id");
	$Defender_hits = mysql_query("SELECT * FROM user_Attack_log WHERE Attack_id='".$Attack['id']."' AND Attacker='defender' ORDER BY id");
	
	if($stat[id] == $Attack[Attacker_id])
	{
		$viewer = "attacker";		
	}
	if($stat[id] == $Attack[Defender_id] && $type =="Player")
	{
		$viewer = "defender";	
	}
	
	$succsessful = 1;
	
	
?>






<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <script type="text/javascript" src="../javascript/backpack.js"></script>
  <script type="text/javascript" src="../javascript/equipment.js"></script>
  <script type="text/javascript" src="../javascript/ajax.js"></script>
  <script type="text/javascript" src="../javascript/JQuery.js"></script>
  <script type="text/javascript" src="../javascript/menu.js"></script>
  
<?php
	if($viewer == "attacker" && $Attack['Win'] == "yes" && $Attack['Type'] == "Mob")
	{
		$succsessful = 1;
?>  
  <script type="text/javascript">
  parent.document.getElementById('mob_<?php echo $Attack['Defender_id']; ?>').style.display = 'none';
  </script>
<?php
	}
	elseif($viewer == "attacker" && $Attack['Win'] == "no" && $Attack['Type'] == "Mob")
	{
		$succsessful = 0;
	}	
	elseif($viewer == "attacker" && $Attack['Win'] == "yes" && $Attack['Type'] == "Player")
	{
		$succsessful = 1;
	}
	elseif($viewer == "attacker" && $Attack['Win'] == "no" && $Attack['Type'] == "Player")
	{
		$succsessful = 0;
	}
	else
	{
		$succsessful = 1;
	}
?>

	<link rel="STYLESHEET" type="text/css" href="../css/attack.css">

</head>

<body bgcolor="#333333" style="margin:0px;" topmargin="0" leftmargin="0" rightmargin="0">
<div valign="middle">
		<table border="0" cellspacing="0" cellpadding="0" style="font-family:Impact,sans-serif;font-weight:normal;font-size:18pt;">
			<tr>
				<td align="center" valign="middle">
					<div id="attacker_name" style="color:#CCC;"><a  style="color:#CCC;text-decoration:none;" href="/profile.php?id=<?php echo $Attack['Attacker_id']; ?>"><?php echo $Attacker_name; ?></a></div>
				</td>
				<td align="center" valign="middle">
					<div id="defender_name" style="color:#CCC;"><?php if($Attack['Type'] == "Player") echo "<a style=\"color:#CCC;text-decoration:none;\" href=\"/profile.php?id=".$Attack['Defender_id']."\">".$Defender_name."</a>"; else echo $Defender_name; ?></div>
				</td>
			</tr>
			<tr height="250px">
				<td width="270" valign="middle" align="center" style="background-image:url(<?php echo $Attacker_pic; ?>);background-repeat:no-repeat;background-position:center center;">
					<table><tr><td id="attacker_window"></td></tr></table>
				</td>
				<td width="270" valign="middle" align="center" style="background-image:url(<?php echo $Defender_pic; ?>);background-repeat:no-repeat;background-position:center center;">
					<table><tr><td id="defender_window"></td></tr></table>
				</td>

			</tr>
			<tr>
				<td align="center" valign="top">
					<div valign="top" align="left" style="border:2px inset;background-color:black;width:228px;"><div id="attacker_health" style="font:bold"></div></div>
				</td>
				<td align="center" valign="top">
					<div valign="top" align="right" style="border:2px inset;background-color:black;width:228px;"><div id="defender_health" align="center" style="font:bold"></div></div>
				</td>
			</tr>
			<tr>
				<td valign="top" align="right">
									</td>
				<td valign="top" align="left">
									</td>
			</tr>
		</table>

<BR><BR>
<!-- Battle Result -->
<a name="battleresults" id="battleresults"></a><div id="battle_result"><div id="result_text"></div><div id="found_items"></div><div></div></div><div id="result_notice_window"></div>
</div>
</body>


<script language="JavaScript">

	function Damage(amount,dmg_type){
		this.amount = amount;
		this.dmg_type = dmg_type;
	}

	var viewer = "<?php echo $viewer; ?>";

	var successful = <?php echo $succsessful; ?>;
	var result_text = document.getElementById('result_text');
	var battle_result = "<?php echo $Attack['Extra']; ?>";

	var attacker_name = "<?php echo $Attacker_name; ?>";
	var defender_name = "<?php echo $Defender_name; ?>";
	

	var attacker_window = document.getElementById('attacker_window');
	var defender_window = document.getElementById('defender_window');

	var result_notice_window = document.getElementById('result_notice_window');

	var attacker_health = document.getElementById('attacker_health');
	var defender_health = document.getElementById('defender_health');

	var newtimeout = 0;

	var attacker_health_start = <?php echo $Attack['Attacker_Hp']; ?>
 
	var defender_health_start = <?php echo $Attack['Defender_Hp']; ?>;

	var attacker_health_new = attacker_health_start;
	var defender_health_new = defender_health_start;
	
	var total_rounds = <?php echo $Total_Rounds; ?>;

	var attacker_taken = new Array();
<?php
	$i = 0;
	while($Defender_hit = mysql_fetch_array($Defender_hits)) 
	{
		$Hit = $Defender_hit['Amount_hit'];
		if($Defender_hit['Attacker_block'] == "yes") $Hit = "block";
		echo "\t\tattacker_taken[".$i."] = '".$Hit."'\n";
		$i++;
	}
	echo "\n";
?>
		
	var defender_taken = new Array();
<?php
	$i = 0;
	while($Attacker_hit = mysql_fetch_array($Attacker_hits)) 
	{
		$Hit = $Attacker_hit['Amount_hit'];
		if($Attacker_hit['Attacker_block'] == "yes") $Hit = "block";
		echo "\t\tdefender_taken[".$i."] = '".$Hit."'\n";
		$i++;
	}
	echo "\n";
?>
	function showDamages(){

		attacker_name = attacker_name.replace(/\'/g,'\\\'');
		defender_name = defender_name.replace(/\'/g,'\\\'');

		for(var x = 0; x < total_rounds; x++){
			if(defender_taken[x]){
				newtimeout = newtimeout + 1000;
				taken = defender_taken[x];
				setTimeout("attacker_window.style.display='none'",newtimeout);
				setTimeout("defender_window.style.display='block'",newtimeout);
				if(taken == "block")
					setTimeout("defender_window.innerHTML='block'", newtimeout);
				else if(taken < 0)
					setTimeout("defender_window.innerHTML='+" + Math.abs(taken) + "'", newtimeout);
				 else
					setTimeout("defender_window.innerHTML='-" + taken + "'", newtimeout);

				if(taken != "block")
                {
					defender_health_new = defender_health_new - taken;
					if(defender_health_new <= 0) defender_health_new = 0;
					health_width = 228 * (defender_health_new / defender_health_start);
					setTimeout('defender_health.style.width="'+health_width+'px"',newtimeout);
				}
			}
			if(attacker_taken[x]){
				newtimeout = newtimeout + 1000;
				taken = attacker_taken[x];
				setTimeout("defender_window.style.display='none'",newtimeout);
				setTimeout("attacker_window.style.display='block'",newtimeout);

				if(taken == "block")
					setTimeout("attacker_window.innerHTML='block'",newtimeout);
				else
					setTimeout("attacker_window.innerHTML='-"+taken+"'",newtimeout);

				if(taken != "block")
				{
					attacker_health_new = attacker_health_new - taken;
					if(attacker_health_new < 0) attacker_health_new = 0;
					health_width = 228 * (attacker_health_new / attacker_health_start);
					setTimeout('attacker_health.style.width="'+health_width+'px"',newtimeout);
				}
			}
		}
		newtimeout = newtimeout + 1000;
		if(successful) {
			var attacker_result = "Win!";
			var defender_result = "Defeated!";

			if(viewer == "attacker")
				var result_notice = "You have won the battle!";
			else if(viewer == "defender")
				var result_notice = "You have been defeated!";
			else
				var result_notice = attacker_name + " has won the battle!";
		}
		else {
			var attacker_result = "Defeated!";
			var defender_result = "Win!";

			if(viewer == "defender")
				var result_notice = "You have won the battle!";
			else if(viewer == "attacker")
				var result_notice = "You have been defeated!";
			else
				var result_notice = defender_name + " has won the battle!";

		}
		setTimeout( function() {
            
                        
            battle_result = battle_result.replace(/\'/g,'\\\'');                       
            result_notice += "<BR><div style='font-size:11pt;'><font color=#ffffff>"+battle_result+"</font></div>";
            result_notice_window.innerHTML = result_notice;
			result_notice_window.style.display = "block";
		}, newtimeout);
		
                
	}

	showDamages();
</script>

