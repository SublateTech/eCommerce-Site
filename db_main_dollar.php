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

			?>  <table style="margin-top:30px"	  height="470" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="22"  colspan="5">
					<div id='center_title'>
					<font size="+1">  DOLLAR BAR SALE </font>
					</div>
				  </td>
				</tr>	

					<tr valign="top">
					  <td width="10%" height="0" rowspan="3"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="64" colspan="2"  align = "left" ><p><font color="#003366" size="4"><b><br>America's Favorite Tasting Chocolate Bars</b></font><br> <font  face="Times New Roman, Times, serif"color="#FF0000" size="3"><i>Put the power of the DOLLAR to work for you.</i></font></p>
                      </td>
                      <td width="13%" rowspan="3">
	  		  
				      </td>
  					</tr>
					<tr valign="top">
					  <td width="43%" height="188"  align = "CENTER" ><div align="left"><FONT face="Arial, Helvetica, sans-serif"><B><FONT size=2><br><br>It's fun and easy to sell</FONT></B><FONT size=2>. Nothing is more recognizable than the American Dollar. Now you can use this time-honored and trusted symbol to help your group raise lots of money. It's easy, $1 for a Dollar Bar. For a dollar purchase or donation, your supporters will receive a One Dollar Bar...now that's value.</FONT></FONT></div></td>
					  <td width="34%"  align = "CENTER" valign="middle" ><img src="images/dollar.jpg" width="210" height="157"></td>
  </tr>
					<tr valign="top">
					  <td height="160" colspan="2"  align = "justify" ><FONT face="Arial, Helvetica, sans-serif"><B><FONT size=2>It tastes great</FONT></B><FONT size=2>. The Original One Dollar Bar is made from the finest milk chcolate and each variety pack comes filled with Creamy Caramel, Roasted Almonds, Crispy Rice and Peanut Butter. All candy bars are a large 2.25 oz. size, and your satisfaction is guaranteed.</FONT></FONT><br><br>
					    <FONT face="Arial, Helvetica, sans-serif"><A href="db_main_fund_form.php"><FONT 
size=2>Click here</FONT></A><FONT size=2> for more information or call us at</FONT> <B><FONT color=#000066 size=3>1.800.645.3863</FONT></B></FONT> 
				      </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>