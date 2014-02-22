<?php
	
	//Checks to make sure user is logged in
	if($Main_Login == true) {
		
		//SQL query to get all the top links
		$Menu = mysql_query("SELECT * FROM `".$maindb."`.`Menu` WHERE `Type`='top' AND `Rank`>=".$playerRank." ORDER BY `Z-Index`");
			
		//Menu Start
		echo "\n\t\t<tr>".
			 "\n\t\t\t<td valign=\"top\" cellspacing=\"0\" cellpadding=\"0\" height=\"30px\">".
			 "\n\t\t\t\t<div class=\"navigation\" height=\"30px\" >".
			 "\n\t\t\t\t\t<ul class=\"menu\">";
		 
		//while statement for all the top menu links 
		while ($Menu_Info = mysql_fetch_array($Menu))
		{
			
			//echos the nessisary information for the top link
			echo "\n\t\t\t\t\t\t<li class=\"".$Menu_Info[Type]."\"><a href=\"".$Menu_Info[Link]."\" class=\"".$Menu_Info["Class"]."\"><span>".$Menu_Info[Title]."</span></a>";
			
			//while statement for all the sub menu links
			$Sub_Menu = mysql_query("SELECT * FROM `".$maindb."`.`Menu` WHERE `top_id`='".$Menu_Info[ID]."' AND `Rank`>=".$playerRank." ORDER BY `Z-Index`");
			$Sub_Menu_Num = mysql_num_rows($Sub_Menu);
			
			//makes sure there are actually sub menus
			if($Sub_Menu_Num >= 1) {
				
				//echos needed html tos tart the sub menu
				echo "\n\t\t\t\t\t\t\t<ul class=\"sub\">";
				
				//while statement for all the sub menu links
				while ($Sub_Menu_Info = mysql_fetch_array($Sub_Menu))
				{
					
						//echos the nesissary  information for sub menu link
						echo "\n\t\t\t\t\t\t\t\t<li><a href=\"".$Sub_Menu_Info[Link]."\" class=\"".$Sub_Menu_Info["Class"]."\">".$Sub_Menu_Info[Title]."</a></li>";
						
				}	
					
				//ends the sub menu
				echo "\n\t\t\t\t\t\t\t</ul>";
				
			}
			
			//ends the top menu
			echo "\n\t\t\t\t\t\t</li>";
			
		}
	
		//ends the menu statement
		echo "\n\t\t\t\t\t</ul>\n";
			
	}

?>