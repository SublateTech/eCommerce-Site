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

			?>  <table style="margin-top:30px"	 height="350" width="100%"> 
			<tr>
					<td  colspan="6" align="LEFT">
						
					<div id='center_title'>
						<font size="+1">  ABOUT US </font>
					
					</div>
					</td>			
			</tr>

					<tr valign="top">
					
						<TD colspan="3" rowspan="2">
					
						</TD>
					<td width="50%"  align = "justify" >&nbsp;<br>
					  <b>Welcome to Signature Fundraising Online!</b><br><br>
                                            <p>We are a national company that provides quality products and excellent services to <font color="#990000"><b>Schools, Daycares, Preschools,</b></font> and other <font color="#990000"><b>organizations. </b></font>We have helped raise over <font color="#990000"><b>$200 Million Dollars </b></font>for such groups. And a 15 year history in the industry has helped <font color="#990000"><b>Signature</b></font> develop many new and exciting ways to make fundraising simple.</p>
                                            <br><br><p> To receive information for your next fund raiser please call us at <font color="#990000"><b>1-800-645-3863 </b></font>and we will be happy to assist you. You may also e-mail us at <a href="mailto:info@sigfund.com">info@sigfund.com</a>. Or if you wish, you may fill out our simple contact information form from here. </p>
                                            <p><br>
					  </p></td>
					<td width="24%" height="200" align="right"><img src="images/logo.jpg" width="177" height="228"></td>
					<td width="11%" rowspan="2">
	  		
				  </td>
    </tr>
					<tr valign="top">
					  <td height="78" colspan="2"  align = "justify" ><font color="#FF0000"><br><br>This site will be updated periodically with exciting new programs and fun activities that coordinate with our prize programs. </font></td>
  </tr>
				</table>
					
		<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>
