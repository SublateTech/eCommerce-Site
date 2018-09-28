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

			?>  <table style="margin-top:30px"	  height="442" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td  colspan="4">
					<div id='center_title'>
					<font size="+1">  COOKIE DOUGH </font>
					</div>
					</td>
				</tr>	

					<tr valign="top">
					  <td width="11%" height="0" rowspan="2"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="250"  align = "CENTER" ><img src="images/ema_lou.jpg" width="433" height="215">
                      </td>
                      <td width="11%" rowspan="2">
	  		  
				      </td>
  					</tr>
					<tr valign="top">
					  <td width="78%" height="132"  align = "justify" ><P><FONT face="Geneva, Arial, Helvetica, san-serif" size="2">Inside our Cookie Dough catalog you'll find a fine assortment of delectable cookies, mixes and treats. Each box of <font color="#990000"><B>Gourmet Cookie Dough</B></font> comes with (48) 1 oz. frozen, pre-portioned cookies.
					    
					    <BR><bR>
					    For more information regarding our Cookie Dough Fundraiser <A href="db_main_fund_form.php">click here</A> </FONT><font size="2" face="Geneva, Arial, Helvetica, san-serif">or call us toll free at <font color="#990000"><b>1-800-645-3863</b></font>. </font></P>
					    </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>