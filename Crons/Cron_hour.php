<?php

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip) {
print "Page restricted.";
exit;
}

include('../includes/Config.php');
mysql_query("update users set exp=exp+ept");
mysql_query("update users set stamina=stamina+spt WHERE stamina<max_stamina");
mysql_query("update users set stamina=max_stamina WHERE stamina>max_stamina");

?>