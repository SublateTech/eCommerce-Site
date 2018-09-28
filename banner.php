<?php 
require_once("db_cart_functions.php");

?>

<table width="100%" height="100px" border="0"  align="center" cellpadding="0" cellspacing="0">
 	<tr>	
		<td>
				<?php	
					$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https://" : "http://";
					echo '<script type="text/javascript">';
	 				/*
						var xmlfile='<?php echo $http ?>'+window.location.hostname+"/cbbanner.php"  //path to ticker txt file on your server.
						//ajax_ticker(xmlfile, divId, divClass, delay, optionalfadeornot)
						new ajax_ticker(xmlfile, "cbbanner1", "", 5000, "fade")
						*/
					print "AddTicker('".$http."');";
					echo '</script>';
					?>
		</td>
	</tr>
</table>
