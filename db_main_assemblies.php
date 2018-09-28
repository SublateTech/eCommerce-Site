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

			?>  <table style="margin-top:30px"	 background="images/map.jpg" height="496" width="100%" bgcolor="#FFFFFF"> 
			
					<tr>
					<td  colspan="6" align="LEFT">
						
					<div id='center_title'>
						<font size="+1">  EDUCATIONAL ASSEMBLIES </font>
					
					</div>
					</td>			
					</tr>
					<tr valign="top">
					
						<TD height="441" colspan="3" rowspan="2">
					
						</TD>
					<td height="311" colspan="2"  align = "justify" ><br><p><font style="font-size:16px "><b>Signature Fundraising's Educational Kick-Off Assemblies </b></font><br><br>
					</p>
					  <p>&nbsp;</p>
					  <p>				    One of <b>Signature's</b> most popular and exclusive bonuses is our <b>Live Educational<br>
					  &quot;Kick-Off&quot; Assembly</b> series. The students and staff will love this funny, fast paced, <br>
					  professionally produced history lessons! And at the same time, we'll get them <br>
					  excited about your fundraiser! Ask one of our <b>Signature Care Team Members</b><br> 
					  about this year's educational assemly theme.*<br>
&nbsp;</p>
					  <p>&nbsp;</p>
					  </td>
					<td width="1%" rowspan="2">
	  		
				  </td>
    </tr>
					<tr valign="top">
					  <td width="41%" height="40px"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td width="49%"  align = "justify" ><font style="padding-top:0;">For more information or to schedule one of our Live<br> <b>Historical Assemblies</b> call us toll free at <b>1-800-645-3863</b>.</font><br><br><font  style="font-size:9px" >*Educational assemblies are subject to availability and school location.</font> </td>
  </tr>
				</table>
					


			
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>