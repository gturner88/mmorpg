<?php


	
	function Secure($value)
	{
		if(!is_numeric($value)) 
		{
			$value = trim($value);
			$value = htmlspecialchars(stripslashes($value));
			$value = str_replace("script", "blocked", $value);
			$value = mysql_escape_string($value);
		}
		return $value;
	}
	
	function javaAlert($string)
	{
		echo "<script type=\"text/javascript\">alert('".secure($string)."')</script>";	
	}
	
	function displayCopyrightinfo()
	{
		$name = "Game name here";
		$year = date("Y",time());
		return "&copy;".$year." ".$name;
	}
	
	function randpass($numchars=8,$digits=1,$letters=1,$sensitive=0)
	{
		$dig = "1234567891234567890";
		$abc = "abcdefghijklmnopqrstuvwxyz";
		if($letters == 1)
		{
			$str .= $abc;
		}
		if($sensitive == 1)
		{
			$str .= strtoupper($abc);
		}
		if($digits == 1)
		{
			$str .= $dig;
		}
		for($i=0; $i < $numchars; $i++)
		{
			$randomized .= $str{rand() % strlen($str)};
		}
		return $randomized;
	} 
	
	function dhmfs ($sec, $padHours = false) 
	{
		$hms = "";
		$hours = intval(intval($sec) / 3600); 
		$hms .= ($padHours) 
			  ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
			  : $hours. ' Hours ';
		$minutes = intval(($sec / 60) % 60).' Min'; 
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT);
		return $hms;
	}
	
	function strip_only($str, $tags) {
		if(!is_array($tags)) {
			$tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
			if(end($tags) == '') array_pop($tags);
		}
		foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
		return $str;
	}
	
	function add_commas($string){
	  $Negative = 0;
	//check to see if number is negative
	  if(preg_match("/^-/",$string)) {
	  //setflag
		$Negative = 1;
	  //remove negative sign
		$string = preg_replace("|-|","",$string);
	  }
		   
		  
	  //look for commas in the string and remove them.    
	  $string = preg_replace("|,|","",$string);
	  
	  //split the string into two First and Second
	  // First is before decimal, second is after First.Second
	  $Full = split("[.]",$string);
	  
	  $Count = count($Full);
		
	  if($Count > 1) {
		$First = $Full[0];
		$Second = $Full[1];
		$NumCents = strlen($Second);
		if($NumCents == 2) {
		//do nothing already at correct length
		}
		else if($NumCents < 2){
		//add an extra zero to the end
		  $Second = $Second . "0";
		}
		else if($NumCents > 2) {
		//either string off the end digits or round up
		// I say string everything but the first 3 digits and then round
		// since it is rare that anything after 3 digits effects the round
		// you can change if you need greater accurcy, I don't so I didn't
		// write that into the code.
		  $Temp = substr($Second,0,3);
		  $Rounded = round($Temp,-1);
		  $Second = substr($Rounded,0,2);
		}  
	  }
	  else {
	  //there was no decimal on the end so add to zeros    
		$First = $Full[0];    
		$Second = "";
	  }
	
	  $length = strlen($First);
	
	  if( $length <= 3 ) {
	  //To Short to add a comma
		$string = $First . "" . $Second;
	   
	  // if negative flag is set, add negative to number
		if($Negative == 1) {    
		  $string = "-" . $string;
		}
			 
		return $string;
	  }
	  else{
		$loop_count = intval( ( $length / 3 ) );
		$section_length = -3;
		for( $i = 0; $i < $loop_count; $i++ ) {
		  $sections[$i] = substr( $First, $section_length, 3 );
		  $section_length = $section_length - 3;
		}
	
		$stub = ( $length % 3 );    
		if( $stub != 0 ) {
		  $sections[$i] = substr( $First, 0, $stub );
		}
		$Done = implode( ",", array_reverse( $sections ) );
		$Done = $Done;
		
		// if negative flag is set, add negative to number
		if($Negative == 1) {    
		  $Done = "-" . $Done;
		}
	
		return  $Done;
	  }
	}
?>
