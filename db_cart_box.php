<?php
require_once("db_cart_functions.php");		

class BoxStd 
{

	
	var $browser = array();
	
	function Header1()
		{?>
		 <div   align="center">
		 <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    		<tr >
      			<td width="16"><img src="images/top_lef.gif" width="16" height="16"></td>
      			<td height="16" background="images/top_mid.gif"><img src="images/top_mid.gif" width="16" height="16"></td>
      			<td width="16"><img src="images/top_rig.gif" width="16" height="16"></td>
   			 </tr>
  			 <tr>
      			<td width="16" background="images/cen_lef.gif"><img src="images/cen_lef.gif" width="16" height="11"></td>
      			<td bgcolor="#FFFFFF">
					<table border="0"  width="100%"  cellpadding="0" cellspacing="0">
						<tr>
							<td  width="100%">
        
		<?php
			}
			
	function Footer1()
		{
		?>					</td>
						</tr>
					</table>
		  		</td>
   			   	<td width="16" background="images/cen_rig.gif"><img src="images/cen_rig.gif" width="16" height="11"></td>
    		</tr>
    		<tr>
      			<td width="16" height="16"><img src="images/bot_lef.gif" width="16" height="16"></td>
      			<td height="16" background="images/bot_mid.gif"><img src="images/bot_mid.gif" width="16" height="16"></td>
      			<td width="16" height="16"><img src="images/bot_rig.gif" width="16" height="16"></td>
   		 	</tr>
 		 </table>
		</div>
		<?php
		}


	function Header()
		{
		//$this->browser = GetBrowser();
		//echo $_SERVER["HTTP_USER_AGENT"].$browser[0]." ".$browser[1];
		//echo $browser[0]." ".$browser[1];
		?>
		<div id="extra">
			
								<?php 	
											//FireFox ?>							
								
								<table  align="center" cellpadding="0"  cellspacing="0" width="100%" border="0"> 
									<tr>
										<td>
									<div id="sb-article" class="sb-article box " >
						
									<table  border="0"  width="100%"  cellpadding="0" cellspacing="0">
										<tr>
										<td width="100%" >

									
						<?php   
					
			}
			
		function Footer()
		{
					?>
												</td>
						</tr>
					</table>
						
						<b class="cn tl"></b>
	  					<b class="cn tr"></b>
    					<b class="cn bl"></b>
    					<b class="cn br"></b>
	
						
				</div>
						
				
										</td>
									</tr>	
					</table> 
				</div>
				<?php
		}
}
?>