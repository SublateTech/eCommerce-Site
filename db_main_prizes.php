<?php 
if (!session_id()) session_start();
			require("db_cart_form_class.php");
			$frobj = new db_cart_form_class(); 

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

			?>  <table style="margin-top:30px"	  height="585" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="41"  colspan="6">
					<div id='center_title'>
					<font size="+1">  Appreciation Gifts </font>
					</div>
					<a name="top"></a>
				  </td>
				</tr>	
					<tr valign="top">
					  <td width="15%" height="365" rowspan="3"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td height="116" colspan="3"  align = "left"  valign="middle"><br><br><b>Signature Fundraising's </b>Appreciation Gifts Brochures are a great way to motivate your sellers to do the best they can. <br><br><br>
					    Click on one of the prize programs below to see the prizes included for each brochure.</td>
                      <td width="13%" rowspan="3">
	  		    
				      </td>
  </tr>
					<tr valign="top">
					  <td width="22%" height="228"  align = "CENTER"  valign="middle"><p><a href="prize_videos.html" target="_blank"><img src="images/batman_cover.jpg" width="116" height="150" border="0"></a></p>
				      <br>
				      <p>Batman</p></td>
                      <td width="23%"  align = "CENTER" valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
					</tr>
					<tr valign="top">
					  <td height="90"  align = "CENTER"  valign="middle"><p>&nbsp;</p>
				      </td>
                      <td height="90"  align = "CENTER"  valign="middle"><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="90"  align = "CENTER"  valign="middle">&nbsp;</td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>