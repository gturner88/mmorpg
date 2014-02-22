<?php

	include("includes/Config.php"); //includes configuration for time and database
	include("includes/Functions.php"); // includes all functions
	$requestMethod = $_SERVER[REQUEST_METHOD]; // gets the request method
	$User_Ip = $_SERVER['REMOTE_ADDR']; // saves the users IP address
	$Main_Login = false; //Declares Login
	
	//secures the $_POSTS and Saves the old post data
	foreach ($_POST as $key => $value) 
	{
		$_OPOST[$key] = $value;
		$_POST[$key] = Secure($value);
  	}
	
	//Secures the $_GETS and saves the old GET data
	foreach ($_GET as $key => $value) 
	{
		$_OGET[$key] = $value;
		$_GET[$key] = Secure($value);
  	}
	
	//Secures the $_COOKIES and saves the old COOKIE data
	foreach ($_COOKIE as $key => $value) 
	{
		$_OCOOKIE[$key] = $value;
		$_COOKIE[$key] = Secure($value);
  	}
	
	// Cookies
	$account_id = $_COOKIE[Account_id];
	$sess_id = $_COOKIE[Account_sessid];
	$uid = $_COOKIE[uid];
	
	//Login Check.
	$Login_sql = "SELECT * FROM `".$maindb."`.`accounts` WHERE id='".$account_id."' and sess_id='".$sess_id."'";
	$logincount=mysql_num_rows(mysql_query($Login_sql));
	
	//checks for logout.
	$logout = $_GET[logout];
	$GET_uid = $_GET[uid];
	
	if(isset($logout))
	{
		setcookie("Account_sessid", "", time()-(60*60*24));
		setcookie("Account_id", "", time()-(60*60*24));
		setcookie("uid", "", time()-(60*60*24));
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: /index.php");
		exit;
	}
	
	// mkes sure 1 account is logged in.
	if($logincount == 1)
	{
		
		//checks if player is trying to chnge characters.
		if(isset($GET_uid))
		{
			setcookie("uid", $GET_uid, time()+(60*60*24));
			$uid = $_GET[uid];
		}
		
		$Main_Login = true;
		$account = mysql_fetch_array(mysql_query("select * from `".$maindb."`.`accounts` where id='".$account_id."' Limit 1"));
		$user_account = "select * from users where id='".$uid."' and account_id='".$account[id]."' Limit 1";
		

		$num_user_account = mysql_num_rows(mysql_query($user_account));
		if(!isset($uid) && !isset($myaccount) && $num_user_account != 1)
		{
			if($num_user_account != 1 && isset($_GET[uid])) $ERROR = "Invalid Account ID!";
			include("includes/Header_account.php");
			exit();
		}
		
		//sets Login Information
		$stat = mysql_fetch_array(mysql_query($user_account));
		include("includes/Updateeverything.php");
		$crew = mysql_fetch_array(mysql_query("select * from `Crew` where id='".$stat[Crew_id]."' Limit 1"));
		$crewRank = mysql_fetch_array(mysql_query("select * from `Crew_ranks` where Crew_id='".$stat[Crew_id]."' and Crew_rank='".$stat[Crew_rank]."' Limit 1"));
	}
	
	if($stat[Rank] != "Admin" && $AdminRequired == true)
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: /index.php");
		exit;
	}
	
	include("includes/Login.php");
	
	if($Main_Login != true && $isLoggedIn == true)
	{
		include("includes/Header_account.php");
		exit();
	}
	else
	{
		
		
		if($stat[Rank] == "Admin") $playerRank = 1;
		elseif($stat[Rank] == "Head_Moderator") $playerRank = 2;
		elseif($stat[Rank] == "Moderator") $playerRank = 3;
		elseif($stat[Rank] == "Helper") $playerRank = 4;
		elseif($stat[Rank] == "Member") $playerRank = 5;
		elseif($stat[Rank] == "Suspended") $playerRank = 6;
		
	if($playerRankRequired != "" && $playerRankRequired < $playerRank)
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: /index.php");
		exit;
	}
	
		
		// Checks if page needs header html information and echos it if it does
		if($noheader != true) include("includes/Header_html.php");
	}
	
?>
