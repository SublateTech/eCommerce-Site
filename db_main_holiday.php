<?php 
if (!session_id()) session_start();
			require_once("db_main_init.php");
			require_once("page.php");
			require_once("db_cart_box.php");

			$page_htm = new page();
			$page_cnt = new Content();
			$page_box = new boxstd();

			
			$page_htm->ShowHeader(); 
			$page_cnt->menu 	=	true;
			$page_cnt->s_bar 	=	false;
			//$page_cnt->t_menu 	=	false;
			$page_cnt->Header(); 
			$page_cnt->Header_Center(); 
			$page_box->Header();

			?>  <table style="margin-top:30px"	  height="500" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="22"  colspan="4">
					<div id='center_title'>
					<font size="+1">  HOLIDAY SHOP </font>
					</div>
				  </td>
				</tr>	

					<tr valign="top">
					  <td width="11%" height="0" rowspan="2"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="217"  align = "CENTER" ><p><img src="images/holidayshop.jpg" width="433" height="215"></p>
                      </td>
                      <td width="11%" rowspan="2">
	  		  
				      </td>
  					</tr>
					<tr valign="top">
					  <td width="78%" height="160"  align = "justify" ><P><STRONG><FONT face="Verdana, Arial, Helvetica, sans-serif" color=#ff0000 
size=3><A href="http://www.giftav.com">Gift Avenue</A> </FONT></STRONG><FONT 
face="Verdana, Arial, Helvetica, sans-serif" size=2><SPAN class=style1>is different than the other School Holiday Shopping Progams! Gifts are our passion...and we understand the importance and nuance of Great Gift Giving for children. When a child gives a gift, they want the moment to be very special. That's why we've designed a unique collection of top quality gifts and services to make your shopping program easy, convenient, impactful, and stress-free.</SPAN></FONT></P><BR><BR>
					    <P><FONT face="Verdana, Arial, Helvetica, sans-serif" size=2><A 
href="http://www.seegiftavenue.com">Click Here</A> for more information on Gift Avenue or call us toll free at<br> <B><FONT color=#000066>1. 800.645.3863</FONT></B></FONT></P>
				      </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>