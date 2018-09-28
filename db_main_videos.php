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

			?>  <table style="margin-top:30px"	  height="550" width="95%" bgcolor="#FFFFFF">
					<!--DWLayoutTable--> 
			
					<tr>
					  <td height="22"  colspan="6" align="LEFT">
					  <div id='center_title'>
					  <font size="+1" color="">Promotional Media </font></td>
  </tr>
  <tr>
    	<td height="21" colspan="2">    
    	<td width="194">&nbsp;</td>
 	 	<td width="94">&nbsp;</td>
  	<td width="173">&nbsp;</td>
  <td width="72">&nbsp;</td>


  <tr>
	<td width="117" height="98">&nbsp;</td>
	<td  colspan="4" align="LEFT" valign="top">
						
					
		<p><font size="+1" color="#990000">Videos &amp; DVDs</font><br><br></p>
    Signature provides professionally produced &quot;Kick-Off&quot; videos and DVDs to introduce and motivate your students towards a successful fundraiser. These videos can be played in the classroom or at a school-wide assembly. They can also be used as a mid-fundraiser promotion to remind the students that the fundraiser is still underway! </td>			
    <td align="LEFT" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr valign="top">
					  <TD height="100">&nbsp;</TD>
					  <TD colspan="3" valign="top"><p>Click on a link below for a peak at some of our past videos!</p><br><br>					    
					  <p>*<a href="#">King of the fundraiser</a><br>
				      *<a href="#">Fundraiser Guy</a><br>
				      *<a href="#">Captain Fundraiser</a></p></TD>
					  <td  align = "center" valign="top"  ><img src="images/dvd.jpg" width="159" height="140"></td>
  					  <td  align = "justify" valign="top" ><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
					<tr valign="top">
					  <TD height="10">&nbsp;</TD>
					  <TD colspan="4" valign="top"><p><font size="+1" color="#990000">Audio Promos</font></p>                        <p><br>
        Another exclusive service provided by Signature is our Stan The Man! 
        audio promotional CD series. These one to two minute audio promos are 
        hosted by (fictitious radio show legend) <b>Stan The Man Stevens</b>, 
        who, along with his hilarious cast of characters, instruct, motivate and 
        remind the students about the fundraiser. These brief, funny promos can 
        be played at convenient times throughout the fundraiser both in the classroom 
        and/or over the school P.A. system.</p><br><br></TD>
                      <TD valign="top"><!--DWLayoutEmptyCell-->&nbsp;</TD>
  </tr>
					<tr valign="top">
					  <TD height="106">&nbsp;</TD>
					  <TD colspan="2" valign="top"><p>Click on links below to hear samples!<br><br> 
					  </p>                        
				      <p>* <a href="images/Stan_1.mp3">Stan The Man</a> </p>                        </TD>
                      <TD colspan="2" valign="top" align="center"><img src="images/cd.jpg" width="134" height="88"></TD>
  <TD>&nbsp;</TD>
  </tr>
					<tr valign="top">
					  <TD height="0"></TD>

  </tr>
				</table>
					


			
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>