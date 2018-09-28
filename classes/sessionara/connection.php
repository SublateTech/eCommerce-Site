<?
// change the values here to fit your environment!
	$db_host = "localhost";		// server host
	$db_user = "sa";			// your username
	$db_user_pw = "";		// your password
	$db_defdb = "test";			// default database to use

$conn = mysql_connect ($db_host,$db_user,$db_user_pw) or die ("Could not connect");
mysql_select_db($db_defdb,$conn) or die ("Could not select DB");
?>