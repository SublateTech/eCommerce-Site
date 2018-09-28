<?php 
if (!session_id()) session_start();
if (!isset($_SESSION['sig_secret']))
	header("Location: sig_secret\db_main_sig_secret.php");

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

			?>
  <table style="margin-top:30px"	  height="594" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="41"  colspan="4">
					<div id='center_title'>
					<font size="+1">  SIG SECRET </font>					</div>
					<a name="top"></a>				  </td>
				</tr>	
					<tr valign="top">
					  <td width="23%" height="243" rowspan="3"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td width="48%" height="38"  align = "CENTER" >
					    <div align="center"><strong>CD Stereo System w/Remote </strong>					      </div></td>
                      <td width="29%" rowspan="3">				      </td>
  </tr>
					<tr valign="top">
					  <td height="121"  align = "CENTER" ><img src="images/stereo.jpg" width="382" height="220" /></td>
    </tr>
					<tr valign="top">
					  <td height="209"  align = "CENTER" ><p><b>MP3 Player </b></p>
				        <p><img src="images/MP3_Player.jpg" width="382" height="220" /></p></td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>