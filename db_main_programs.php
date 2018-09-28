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

			?>  <table style="margin-top:30px"	  height="300" width="100%" bgcolor="#FFFFFF"> 
					<tr valign="top">
					  <td width="11%" height="0" rowspan="2"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td width="61%" height="74" colspan="2"  align = "justify" ><p><font style="font-size:14px"><b><br>Signature Fundraising Inc. offers a wide variety of fund raising <br>programs to suit your schools or organizations needs.</b></font></p>
                      <p>&nbsp;  </p> </td>
                      <td width="3%" rowspan="2">
	  		  
				      </td>
  </tr>
					<tr valign="top">
					  <td width="61%" height="300"  align = "justify" ><font style="font-size:13px" color="#990000">
					    <p>Choose the right fund raiser for you!</p>
					  </font>
                        <p>&nbsp;</p>
						
                        <br><p>- <a href="db_main_fall_catalog.php">Catalog/Brochure Sale</a></p>
                        <br><p>- <a href="db_main_cookie.php">Cookie Dough Sale</a></p>
                        <br><p>- <a href="db_main_magazine.php">Magazine Sale</a></p>
                        <br><p>- <a href="db_main_holiday.php">Holiday Shop</a></p>
                        <br><p>- <a href="db_main_dollar.php">Dollar Bar Sale</a></p>
                        <br><br><br>To talk to a live <b>Customer Care Representative</b> regarding one of our available programs, please call us toll free at
<b>1-800-645-3863.</b><br>
<br>
Our <b>Customer Care Staff</b> are available to take your calls <b>Mon. - Fri. 6am - 5pm (PST)</b>. </td>
					  <td width="25%" align = "justify"  valign="top" ><font style="padding-top:0;"><img src="images/girl.jpg" width="247" height="320"></font></td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>