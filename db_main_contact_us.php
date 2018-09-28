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

			?>  <table style="margin-top:30px"	 height="400px" width="100%" bgcolor="#FFFFFF"> 
			<tr>
					<td  colspan="5" align="LEFT">
						
					<div id='center_title'>
						<font size="+1">  CONTACT US </font>
					
					</div>
					</td>			
			</tr>

					<tr valign="top">
					
						<TD colspan="3">
						  <table width="183" border="0" bgcolor="#FFFFFF">
                            <tr>
                              <tD width="173" height="243" align="right" bgcolor="#FFFFFF" scope="row"><img src="images/lady.jpg" width="161" height="239"></tD>
                            </tr>
                            <tr>
								<td  height="110px" align="center">
								<!-- (c) 2006. Authorize.Net is a registered trademark of Lightbridge, Inc. --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="47c70948-4b07-4974-8e1d-077b57c71956";</script> <script type="text/javascript" language="javascript" src="//VERIFY.AUTHORIZE.NET/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Accept Credit Cards</a> </div> 
								</td>
                            </tr>
                            <tr>
                                                            <td height="99" align='center' >
	 		<div id="cilgat" style="z-index:100;position:absolute"></div>
	 		<div id="sclgat" style="display:inline"></div>
	 		<div id="sdlgat" style="display:none"></div>
	 		<script type="text/javascript">var selgat=document.createElement("script");selgat.type="text/javascript";selgat.defer=true;selgat.src=(location.protocol.indexOf("https")==0?"https://secure.providesupport.com/image":"http://image.providesupport.com")+"/js/signature/safe-standard.js?ps_h=lgat\u0026ps_t="+new Date().getTime();document.getElementById("sdlgat").appendChild(selgat)</script><noscript><div style="display:inline"><a href="http://www.providesupport.com?messenger=signature">Live Support</a></div></noscript>
	   
    	</td>

                            </tr>
                          </table>
					
						</TD>
					<td width="67%"  align = "justify" ><p><br><br>&nbsp;</p>
					  <p><b><font   style=" font-size:17px " >Need Help? We make it quick and easy to get answers to your questions.</font></b><br>
				        <br><br><br>
				        <b><font color="#FF0000">Call us toll free:</font></b><br>
				      <b>1-800-645-3863 </b>or fax us at: <b>1-800-898-7702</b></p>
					  <br>
					  <p>Our live Customer Care staff will be ready to provide promt and fast resolutions to any matter. Operators are available for assistance <b>Mon - Fri from 6am - 5pm (PST)</b></p>
					  <br><p><b><font color="#FF0000">Contact us by e-mail:</font></b><br>
					    Send all questions comments to <a href="mailto:info@sigfund.com">info@sigfund.com.</a></p>
					  <br><p><b><font color="#FF0000">Help Page:</font></b><br>
					  Visit our <a href="db_main_faq.php">FAQs(Frequently Asked Questions)</a> for answers to all your questions, from starting a fundraiser to purchasing items at our <a href="db_cart_main.php">Online Store.</a></p>
					  <br><p><b><font color="#FF0000">Career Opportunities:</font></b><br>
					  Visit our <a href="www.sigfund.com/SigFund/career.htm">Career Center </a>and learn more about various career opportunities.</p><br>
					  <p><b><font color="#FF0000">Driving Directions:</font></b><br>
					  Please click on the link provided- Map Quest </p><br><p><b><font color="#FF0000">Have a question?:</font></b><br>
					  Just <u>click here </u>to submit a question now!.</p></td>
					<td width="7%">
	  		
				  </td>
    </tr>
				</table>
					


			
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>