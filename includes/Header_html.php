<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <LINK REL=StyleSheet HREF="css/main.css" TYPE="text/css">
  <LINK REL=StyleSheet HREF="css/menu.css" TYPE="text/css">
  <script type="text/javascript" src="javascript/backpack.js"></script>
  <script type="text/javascript" src="javascript/equipment.js"></script>
  <script type="text/javascript" src="javascript/ajax.js"></script>
  <script type="text/javascript" src="javascript/JQuery.js"></script>
  <script type="text/javascript" src="javascript/menu.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title></title>
  </head>
  <body bgcolor="#200000" id="body">
  <div id="select">
  <center>
  <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">

   <tr>
     <td height="150" colspan="3" class="main_banner"></td>
   </tr>
   <tr width=100% height=30 class="menu_background" cellspacing="0" cellpadding="0"><td>
    <table width=100%><tr><td align=left> 
    	<select class=combobox id="combo_uid" onChange="swapuser();" style="font-size:8pt;width:120px;">
<?php
	$accounts = mysql_query("SELECT * FROM users WHERE account_id='".$account[id]."'");
	while($row = mysql_fetch_array($accounts)) 
	{
		if($row[name] == $stat[name])
		{
			$selected="selected";
		}
		else
		{
			$selected="";
		}
		echo"<option value=\"".$row[id]."\" ".$selected.">".$row[name]."</option>";
	} 
			
	$growthtoday = $stat[exp] - $stat[Y_exp];
	$adrenaline =  floor((($stat[adrenaline])/($stat[max_adrenaline]))*100);
	if($adrenaline >= 100)
	{
		$max = 0;
	}
	else
	{
		$max = 1;
	}
	
	if($adrenaline >= 0)
	{
		$max = 0;
		$min = 100;
	}
	else
	{
		$max = 1;
		$max = 0;
	}
	
	$levels = mysql_query("SELECT * FROM ".$maindb.".Level WHERE level='".$stat[level]."'");
	while($level = mysql_fetch_array($levels)) 
	{
		$minlevel = $level[exp];
	}
	
	$levels = mysql_query("SELECT * FROM ".$maindb.".Level WHERE level=1+'".$stat[level]."'");
	while($level = mysql_fetch_array($levels)) 
	{
		$nextlevel = $level[exp];
		$levelexp = ($nextlevel)-($stat[exp]);
	}
	
	if($levelexp <= 0)
	{
		$levelexp = "LEVEL!";
		$levelfont=" color=green";
	}
	else
	{
		$levelexp = add_commas($levelexp);
	}
	
	if($stat[stamina] >= $stat[max_stamina])
	{
		$stamcolor = "color=\"green\"";
	}
	
	if($stat[level] == 70)
	{
		$level_info = "<b>Growth today:</b> ".add_commas($growthtoday)."<br><b>Per turn:</b> ".add_commas($stat[ept])."<br><b>Minimum:</b> ".add_commas($minlevel)."";
	}
	else
	{
		$level_info = "<b><font".$levelfont.">Needed to level:</b> ".$levelexp."</font><br><b>Growth today:</b> ".add_commas($growthtoday)."<br><b>Per turn:</b> ".add_commas($stat[ept])."<br><b>Minimum:</b> ".add_commas($minlevel)."";
	}
	
?>
        </select>
          </td><td align=left>
          	<div onMouseover="fixedtooltip('<b>Points:</b> <?php echo add_commas($account[points]); ?>', this, event)" onMouseout="delayhidetip()"><img src="images/points.jpg" width="15" height="15" /></div>
		  </td><td align=left>
          	<div id="curTime" class="stat_div">Time: <?php echo date("g:i a", $ctime); ?></div>
          </td><td align=left>
         	<div class="stat_div" onMouseover="fixedtooltip('<b>Attack:</b> <?php echo add_commas($stat[attack]); ?><br><b>Hitpoints:</b> <?php echo add_commas($stat[hitpoints]); ?><br><b>Critical:</b> <?php echo add_commas($stat[critical]); ?>%<br><b>Block:</b> <?php echo add_commas($stat[block]); ?>%', this, event)" onMouseout="delayhidetip()">LEVEL: <?php echo add_commas($stat[level]); ?></div>

          </td><td align=left>
          	<div class="stat_div" onMouseover="fixedtooltip('<?php echo $level_info; ?>', this, event)" onMouseout="delayhidetip()">
            	<font<?php echo $levelfont; ?>><div id="curEXP">XP: <?php echo add_commas($stat[exp]); ?></div></font>
            </div>
          </td><td align=left>
          	<div id="curStamina" class="stat_div" onMouseover="fixedtooltip('<b>Per turn:</b> <?php echo add_commas($stat[spt]); ?><br><b>Max:</b> <?php echo add_commas($stat[max_stamina]); ?>', this, event)" onMouseout="delayhidetip()"><font <?php echo $stamcolor; ?>>Stamina: <?php echo add_commas($stat[stamina]); ?></font></div>
          </td><td align=left>
          	<table cellspan="1" cellspacing="0" cellpadding="0" align="center" class="bar" width="100px" onMouseout="delayhidetip()" onMouseover="fixedtooltip('Adrenaline: <?php echo $adrenaline; ?>%', this, event)">

    			<td id="bar"><div id="Rage_bar" width="<?php echo $adrenaline; ?>%">&nbsp;</div></td>
            </table>
          </td>
          <td width=315></td>
          <td align=right valign=top><img width=20px height=20px src="images/backpack.jpg" onclick=loadbp("",250);></td>

          <td align=right valign=top><img width=20px height=20px src="images/armor.png" onclick=loadeq("",300);></td>
          </tr>
          </table>

         </td>         
     </tr>
     <?php include("includes/Menu.php"); ?>
     <tr>
     <td width="870" bgcolor="#666666" align=center valign=top>     
     <!-- Header Ends Here -->