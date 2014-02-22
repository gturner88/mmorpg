<?php
	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Home"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header
	
	function strip_html_tags( $text )
	{
		$text = preg_replace(
			array(
			  // Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<object[^>]*?.*?</object>@siu',
				'@<embed[^>]*?.*?</embed>@siu',
				'@<applet[^>]*?.*?</applet>@siu',
				'@<noframes[^>]*?.*?</noframes>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
				'@<noembed[^>]*?.*?</noembed>@siu',
			  // Add line breaks before and after blocks
				'@</?((address)|(blockquote)|(del)|(table)|(a))>@iu',
				'@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))>@iu',
				'@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))>@iu',
				'@</?((table)|(th)|(td)|(tr)|(caption))>@iu',
				'@</?((form)|(button)|(fieldset)|(legend)|(input))>@iu',
				'@</?((label)|(select)|(optgroup)|(option)|(textarea))>@iu',
				'@</?((frameset)|(frame)|(iframe))>@iu',
			),
			array(
				'', '', '', '', '', '', '', '', '', '', '',
				"", "", "", "", "", "",
				""
			),
			$text );
		return $text;
	}
	$text = $_POST[text];
	if($text == "")
	{
		$text = $stat[Description];
	}
	else
	{
		$text = sqlstop($text);
		$text = strip_html_tags($text);
		mysql_query("UPDATE users SET Description='$text' WHERE id=$stat[id]");
	}
	echo "<center>Advanced Profile<br><form method=post><textarea name=\"text\" rows=\"10\" cols=\"60\">".$text."</textarea><br><input type=submit value=Submit!></form></center>";
	include("includes/Footer.php");
?>