<?php
	
	$Username = $_POST[Username];
	$Password = $_POST[Password];
	
	if(isset($Username) && isset($Password))
	{
		$Login_sql = "SELECT * FROM `DB_Main`.`accounts` WHERE username='".$Username."' and password='".$Password."'";
		$Login=mysql_fetch_array(mysql_query($Login_sql));
		$Login_count=mysql_num_rows(mysql_query($Login_sql));
		
		if($Login_count == 1)
		{
			$sessid = randpass(32,1,1,1);
			setcookie("Account_sessid", $sessid, time()+(60*60*24));
			setcookie("Account_id", $Login['id'], time()+(60*60*24));
			mysql_query("UPDATE `DB_Main`.`accounts` SET sess_id='".$sessid."' WHERE username='".$Username."'"); 			
			
			$Main_Login = true;
			$account = $Login;
			
		} 
		else
		{
			$Main_Login = false;
			$LE = "Invalid Username or Password!";
		}
	}

?>
