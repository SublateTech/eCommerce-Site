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

			?>  <table style="margin-top:30px"	  height="496" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="22"  colspan="4">
					<div id='center_title'>
					<font size="+1">  MAGAZINE SALE </font>
					</div>
				  </td>
				</tr>	

					<tr valign="top">
					  <td width="11%" height="0" rowspan="2"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="290"  align = "CENTER" ><p><img src="images/mags.jpg" width="433" height="252"></p>
                      </td>
                      <td width="11%" rowspan="2">
	  		  
				      </td>
  					</tr>
					<tr valign="top">
					  <td width="78%" height="160"  align = "justify" ><P><FONT face="Arial, Helvetica, sans-serif" color=#993300 size=2><B>Signature Fundraising</B></FONT><FONT face="Arial, Helvetica, sans-serif" size=2> is pleased to offer the finest Magazine Fundraisers in the industry. We offer the widest variety of the most popular titles from <B>Sports Illustrated</B> and just about everything in-between!</FONT><br><br>
					    <FONT face="Arial, Helvetica, sans-serif" size=2>For more information regarding our magazine sale please <A href="db_main_fund_form.php">click here</A> or call us toll free at <B>1-800-645-3863</B>.<br><br>Go to our <a href="db_cart_main.php?Brochure=13">Online Shopping</a> area now to purchase one or more of these great titles.</FONT> </P>
				      </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>