<?php
$ip = $_SERVER['REMOTE_ADDR'];
if ($ip) {
print "Page restricted.";
exit;
}
include('../includes/Config.php');
mysql_query("update user_Items set Time_Left=Time_left-1 WHERE Timer='yes' AND Time_Left>0");
mysql_query("DELETE FROM user_Items WHERE Timer='yes' AND Time_Left<1");

?>