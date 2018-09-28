<?php 


if (!session_id()) session_start();

			require_once("db_main_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");
			

			$page_htm = new page();
			$page_cnt = new Content();
			$page_box = new boxstd();


			$page_htm->ShowHeader(); 
			$page_cnt->menu 	=	false;
			$page_cnt->s_bar 	=	false;
			//$page_cnt->t_menu 	=	false;
			
										
			$page_cnt->Header(); 
			
			
			$page_cnt->Header_Center(); 
			$page_box->Header();
			


			?>
<style type="text/css">
<!--
.style1 {font-size: 24px}
.style2 {color: #FF0000}
-->
</style>
  <table style="margin-top:45px" align="center"	 height="450" width="90%" border="0"> 
			<tr valign="top">
				
					<td height="264" colspan="4" align="center" >
					<?php /*
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="775" height="262">
                      <param name=movie value="images/Movie3.swf">
                      <param name=quality value=high>
					  <param name=loop value=0>
					  <param name="wmode" value="windows"> 
					  
                      <embed src="images/Movie3.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="775" height="262"> </embed>
                    </object> */?>
	  					<img src="images/index_text.jpg">
				  </td>
					
			</tr>
			<tr valign="top">
			  <td  width="35%" height="159" colspan="3" align="right" ><div align="left">
			    <?PHP /*<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  style="text-decoration:none"  href="images/Stunt.wmv">Remote Control Car</a> */?>
				<p><br>
			    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  style="text-decoration:none"  href="images/tspweb_100k.wmv">Check out our <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Service Program video!</a><br /><br>
			    </p>
			    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  style="text-decoration:none" href="db_cart_main.php">Shop Online Now!, FREE <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;shipping on purchases $40 or more!</a> </p>
				
			    <br>
			    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  style="text-decoration:none" href="db_main_spring_catalog.php">Preview our new Spring 2009 Catalog!</a><br />
				<a  style="text-decoration:none" href="db_main_extravagant_events.php" target="page" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=467,height=440,left=50,top=50,titlebar=yes')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/logo_1.jpg" /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Check out our new division<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature Extravagant Events</a><br />
				 
			  </div>
			  			  <p align="center">&nbsp;</p>
              <p>
		  		<p  align="left"><a href="images\Order Form.pdf" >  <font size="-1"  color="#990000" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Order Form Download</font></a></p>
			  <br>
              </p>

			  
			  </td>
              <td width="52%" align="right" ><p><img src="images/index_1.jpg" width="418" height="157"></p>
			  
			  	<p align="center"><font color="#FF0000" > <b> HOT NEWS RELEASE!  </b></font><br /><br /></p>
				
				<p align="left"> <font size="2" >There has been talk recently regarding the closing of a major supplier in the fundraising industry. Signature Fundraising is pleased to announce that this will not affect our customers in any way. Signature designs and imports our own product line and therefore we are unaffected by this development. We look forward to continuing to bring you the highest quality products in fundraising at the most affordable prices! </font>     </p>         
			  
			  </td>
  </tr>
  			<tr>
				<td height="180" width="100%" colspan="5" >
					<table width="100%" border="0" height="180">
							<tr>
								<td width="45%">
								
								</td>
								<td align="center" width="65%">
									<table width="100%">
											 
									<tr>
										<td valign="top"  align="left">
											<p><br>
		  		<p  align="center"><a href="http://www.signaturefundraising.com/db_cart_main.php?Home" >  <font size= size="7" color="#FF0000"   >Shop Online to support our future generation! Free shipping on purchases $40 or more.</font></a></p>
			  <br>
              </p>
              <p align="center">                <a href="db_main_tell_a_friend.php" target="page" class="style1"  style="text-decoration:none" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=630,height=600,left=50,top=50,titlebar=yes')"><font size="4"> Click here to tell family & friends
                  about your fundraiser!</font></a></p>
              
									 	</td>
									 </tr>

									</table>
								</td>
							</tr>
					</table>
  
  				</td>
  			</tr>

					
				</table>
					


			
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>