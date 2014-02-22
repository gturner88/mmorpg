<?php
$ip = $_SERVER['REMOTE_ADDR'];
if ($ip) {
print "Page restricted.";
exit;
}
include('../includes/Config.php');
mysql_query("update users set Y_growth=exp-Y_exp");
mysql_query("update users set Y_exp=exp");
mysql_query("TRUNCATE TABLE `mob_Attack_log`");

?>