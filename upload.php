<?php

	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title="Upload Profile Image";  //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header

$action = $_GET[action];
$imagefile = $_FILES['imagefile']['tmp_name'];
if ($action == upload) {
$size=getimagesize($imagefile);
$k=filesize($imagefile);
$width=$size[0];
$height=$size[1];
if ($width > 250 || $height > 250) {
$ERROR = "Image Must Be 250x250";
include("includes/Error.php");
include("includes/Footer.php");
exit;
}
if ($k > $stat[Image_size] ) {
$imagesize = ($stat[Image_size])/(1000); 
$ERROR = "Image File Size Must Be Less Than ".$imagesize."Kb(".$stat[Image_size]." Bytes)";
include("includes/Error.php");
include("includes/Footer.php");
exit;
}
if (!$imagefile) {
$ERROR = "You Must Select A File To Upload";
include("includes/Error.php");
include("includes/Footer.php");
exit;
}
$type=$_FILES['imagefile']['type'];
copy ($_FILES['imagefile']['tmp_name'], "profile/".$stat[id].".gif") or die ("Could not copy");
$imagesize = ($k)/(1000); 
print "Image Uploaded Successfully<br>$size[0] x $size[1]<br>".$imagesize."Kb(".$k." Bytes)";
mysql_query("UPDATE users SET img='yes' WHERE id=$stat[id]");
}
$imagesize = $stat[Image_size]/1000;
print "
<center>
250x250 Size<br>
".$imagesize."K Max File Size<br>
Only .jpg, .bmp, and .gif Formats Excepted<br>
<form method=post action=?action=upload enctype=multipart/form-data>
<input type=file name=imagefile>
<br>
<input type=submit name=Submit value=Submit><br></form>
";

	
	
include("includes/Footer.php"); //includes Footer 
?>