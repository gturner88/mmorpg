<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "World"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header
	
	?>
    <link rel="stylesheet" type="text/css" href="css/chromestyle4.css" />

<script type="text/javascript" src="javascript/chrome.js"></script>
<style type="text/css">
.inputtext { width: 475px; height: 44px; }
</style>
<style type="text/css">
.html-marquee {height:20px;width:365px;background-color:200000;font-family:Cursive;font-size:12pt;color:800517;border-width:1;border-style:dotted;border-color:000000;}
</style>
  <LINK REL=StyleSheet HREF="http://domain.com/css/main.css" TYPE="text/css">
  <LINK REL=StyleSheet HREF="http://domain.com/css/menu.css" TYPE="text/css"> 

<table border="0" width="900px">
<tr>
<td>
<div class="chromestyle" id="chromemenu">
<ul>
<li><a href="#" rel="dropmenu1">Edit Crew</a></li>
<li><a href="#" rel="dropmenu2">Crew Actions</a></li>

<li><a href="#" rel="dropmenu3">Crew Storage</a></li>
<li><a href="#" rel="dropmenu4">Accomplishments</a></li>

		
</ul>
</div>

<!--1st drop down menu -->                                                   
<div id="dropmenu1" class="dropmenudiv">
<a href="http://jifrenoutwar.webege.com/Crew%20Home/index.html">Crew Home</a>
<a href="http://domain.com/new.php">Crew Profile</a>
<a href="http://domain.com/new.php">MOTD</a>

<a href="http://domain.com/new.php">Invites</a>
<a href="http://domain.com/new.php">Edit Description</a>
<a href="http://domain.com/new.php">Edit Logo</a>
<a href="http://domain.com/new.php">Crew Upgrades</a>
<a href="http://domain.com/new.php">Change Ranks</a>
<a href="http://domain.com/new.php">Change Rank Names</a>
<a href="http://domain.com/new.php">Boot Members</a>
</div>


<!--2nd drop down menu -->                                                
<div id="dropmenu2" class="dropmenudiv">
<a href="http://domain.com/new.php">Action Log</a>
<a href="http://domain.com/new.php">Raids Forming</a>
<a href="http://domain.com/new.php">Crew Hitlist</a>
<a href="http://domain.com/new.php">Hitlist Statistics</a>
<a href="http://domain.com/new.php">Raid Boss Spawns</a>
<a href="http://domain.com/new.php">Forums</a>
</div>

<!--3rd drop down menu -->                                                   

<div id="dropmenu3" class="dropmenudiv">
<a href="http://domain.com/new.php">Crew Vault</a>
<a href="http://domain.com/new.php">Point Bank</a>
<a href="http://domain.com/new.php">Upgrade Stones</a>
</div>

<!--4th drop down menu -->                                                   
<div id="dropmenu4" class="dropmenudiv">
<a href="http://domain.com/new.php">Raid Results</a>
<a href="http://domain.com/new.php">Cap Status</a>
<a href="http://domain.com/new.php">Crew Medals</a>

<a href="http://domain.com/new.php">Trophy Room</a>
</div>




<script type="text/javascript">

cssdropdown.startchrome("chromemenu")

</script>
</td>
<td>
<table>
<tr>
<td>
<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="5">Rape Some Raids!</marquee>
</td>

<td>
<img src=images/motd.png></img>
</td>
</tr>
</table
></td>
</tr>
<tr>
<td valign="top">
<table cellspacing="0" style="width:477px;">
<tr>
<td style="background-image: url(images/Crewinformation.png); background-repeat: no-repeat;border-bottom:1px #000 Solid;" height="34px"> 
</td>
</tr>
<tr>
<td style="background-image: url(images/backgroundforcrewactions2.png); background-repeat: no-repeat;border:1px #000 Solid;"> 

<table border="0" align="left" width="475px" cellpadding="1">
<tr>
<th align="left">Created By:</th>
<td align="right">Unknown</td>
<tr>
<th align="left">Created On: </th>
<td align="right">Unknown </td>
<tr>
<th align="left">Leader:</th>
<td align="right">Kidd</td>
<tr>
<th align="left">Total Members:</th>
<td align="right">1</td>
<tr>
<th align="left">Average Level:</th>
<td align="right">70</td>
</tr>
</table> 
	
</tr>
<td height="34px"> 

</td>
<tr>
<td style="background-image: url(images/Crewactions.png); background-repeat: no-repeat;border-bottom:3px #000 Solid;" height="34px"> 
</td>
</tr>
<tr>
</tr>
<tr>
<td style="background-image: url(images/backgroundforcrewactions2.png); background-repeat: no-repeat;" height="195px"> 

</td>
</tr>
</table> </td>

<td valign="top">
<table style="border:1px #000 Solid;" cellspacing="0" cellpadding="0"  valign="top"><tr>
<td style="border-bottom:3px #000 Solid;"><img src=images/Crewstickiestitle.png /></td>
</tr>
<tr>
<td height="380px" valign="top">

</td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="2">
    <table align="center" cellpadding="1" cellspacing="0">
        <tr>
            <td width="345px" height="31px" style="background-image: url(images/Memberstitle.png); background-repeat: no-repeat;"></td>
            <td width="1%"></td>
            <td width="548px" height="31px" style="background-image: url(images/Crewshoutboxtitle.png); background-repeat: no-repeat;">
        </tr>
        <tr>
            <td height="400px" valign="top" style="background-image: url(images/crewmembersbackground.png); background-repeat: no-repeat;"> </td>
            <td></td>
            <td style="border:solid 1px #000;"></td>
        </tr>    
    </table>
    </td>
</tr>
</table>
<br/>
<?php include("includes/Footer.php");