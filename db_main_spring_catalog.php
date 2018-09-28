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

			?>  <table style="margin-top:30px"	  height="468" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td  colspan="4">
					<div id='center_title'>
					<font size="+1">  SPRING BROCHURE </font>
					</div>
					</td>
				</tr>	

					<tr valign="top">
					  <td width="11%" height="0" rowspan="2"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
                      <td height="240"  align = "CENTER" ><p><font style="font-size:14px"><b>
                              <a href="view/db_main_view_spring.php" target="_new"><img src="images/brochure1.jpg" width="433" height="215" border="0"></a>
</b></font></p>
                        <p><FONT face="Geneva, Arial, Helvetica, san-serif" color=#993300 size=2><br>Click image to view our new Spring 2009 Catalog!</FONT></p>
                      </td>
                      <td width="11%" rowspan="2">
	  		  
				      </td>
  					</tr>
					<tr valign="top">
					  <td width="78%" height="168"  align = "justify" ><FONT face="Geneva, Arial, Helvetica, san-serif" size=2><br><br>Inside our catalog you'll find a wide variety of
  wonderful items, many of which are <b>Signature Exclusives</b>--they aren't available anywhere else!</FONT><br>  <BR>
  <a href="db_main_fund_form.php">Click here </a>for more information regarding our <b>Spring 2008 Catalog Fundraiser</b> or call us at <b>1-800-645-3863.</b><br>
  <br>
				      				      </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>