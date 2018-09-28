<?php 
//if (!session_id()) session_start();
//require "page.php";

if  ($_SERVER['HTTP_HOST'] == 'localhost')
	{
		$_SESSION['testing_mode'] = 'on';
	}
	else
	{
		print $_SERVER['HTTP_HOST'];
	}
	
	

?>
