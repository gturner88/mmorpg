<?php

if($ERROR != "") {
	 echo "<div class=\"error\">".$ERROR."</div>";
	 $ERROR = "";
}
elseif($INFO != "") {
	echo "<div class=\"info\">".$INFO."</div>";
	$INFO = "";
}
elseif($SUCCESS != "") {
	echo "<div class=\"success\">".$SUCCESS."</div>";
	$SUCCESS = "";
}
elseif($WARNING != "") {
	echo "<div class=\"warning\">".$WARNING."</div>";	
	$WARNING = "";
}


?>
