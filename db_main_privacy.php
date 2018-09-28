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

			?>  <table style="margin-top:35px"		 height="500px" width="100%"> 
			<tr   >
				<td  colspan="5">
					<div id='center_title'>
					<font size="+1"> <?php if (!isset($_REQUEST['refund'])) { print"PRIVACY POLICY";} else { print"RETURN AND REFUND POLICY";} ?> </font>
					</div>
				</td>
			</tr>	
			<tr>
					<td  colspan="4" align="right">
						<?php echo "Last Updated : "."January 29, 2007"; ?>
					
					</td>			
			</tr>

					<tr valign="middle">
					
						<TD  width="15%" colspan="3">
					
						</TD>
					<td  align="justify" valign="middle">
											
							
			<?php if (!isset($_REQUEST['refund']))
					{
					
					?>

					  <p><B> Signature Fundraising Privacy Policy </B> <BR><BR>
					  </p>
					  <p><B>Our Privacy Commitment</B><BR><BR>
					  </p>
					  <p>Signature Fundraising Inc. is committed to protecting your privacy. We make every effort to assure your confidentiality and keep your trust. The information you provide us is used to process orders and to assist us in providing you with a more personalized shopping experience. Signature Fundraising Inc. utilizes every available technology to ensure that your confidential information remains that way.</p><BR>
					  <p> <B>Collecting and Using Your Information </B><BR><BR>
                      </p>
					  <p>When you place an order, we'll ask you for your name, e-mail address, mailing address, credit card number and expiration date. This information allows us to process and fulfill your order and to notify you of your order status. Occasionally, we may use your e-mail address to deliver information regarding important functionality changes to the web site, new services, and special offers designed to interest you. If you would rather not receive this type of information, please e-mail us at <a href="mailto:info@sigfund.com">info@Sigfund.com.</a> <BR>
                      </p><BR><BR>
					  <p>Signature Fundraising Inc. uses your purchasing information for the purpose of providing you a more efficient shopping experience and to make our recommendations about merchandise that you might find interesting. We also monitor customer traffic patterns and site usage to help us develop the content, design and layout of the web site. When you visit <a href="www.signaturefundraising.com">www.Sigfund.com</a>, our web server collects information by tracking your domain name (for example "aol.com"), not your unique e-mail address. <BR>
                      </p><BR><BR>
					  <p>When/if you enter a contest or other promotional feature on our web site, we may ask for your name, e-mail address, and mailing address so we can conduct the contest and notify the winners. <BR>
                        <BR>
                      <B>Protecting Your Private Information</B></p><BR>
					  <p> When you place an order or access your Signature Fundraising Inc. account, you are automatically using our secure server. The secure server software (SSL) encrypts all information you enter before it's sent to us. This means that all of the customer information we gather is protected against unauthorized access. <BR><BR>
    
If your web browser does not permit a secure connection, Signature Fundraising Inc. will not accept your credit card information. Your browser should display a "lock" or "key" icon in the lower left-hand corner of your screen when a secure connection is made, and the URL bar on the top of your browser typically shows the first characters as "https." 
    
<BR><BR>All of the customer data we collect, once submitted by you, is protected against unauthorized access. <BR><BR>
    
<B>Using "Cookies"  </B><BR><BR>"Cookies" are small bits of information stored by your browser on your computer's hard drive. Like most e-commerce sites today, Signature Fundraising Inc. uses cookies. Our cookies do not contain any personal information, but they do store your settings and remember your shopping cart contents as you travel through the site, and sometimes between visits. Most web browsers automatically accept cookies.</p><BR>
					  <p><B>Disclosing Your Information to Third Parties</B></p><BR><BR>
					  <p>Signature Fundraising Inc. considers the information you share with us personal and confidential. Signature Fundraising Inc. does not sell, trade, or rent any of your personal information to others. We may choose to do so in the future to trustworthy third parties, however, this will only be done with your permission. 
        
<BR><BR>Signature Fundraising Inc. may also provide aggregate statistics about our customers, sales, traffic patterns and related site information to reputable third parties, but these statistics will include no personally identifying information. Finally, we may release the name, address and email address of sweepstakes entrants to reputable co-sponsors, and to other third parties solely for the purpose of administering such sweepstakes. 
        
<BR><BR>If you visit Signature Fundraising Inc. via a co-branded site--by using a link to our site from a company we do business with--your personal information may be collected by both parties and used by each in accordance with the respective privacy policies. Your credit card information and password are not shared with co-branded businesses. 
        
<BR><BR>Signature Fundraising Inc. releases personal account information, in good faith, when such release is believed to be reasonably necessary. This includes situations in complying with the law, enforcing or applying the terms of any of our user agreements or protecting the rights, property and safety of Signature Fundraising Inc., our customers, or others.</p><BR>
					  <p><B>Your Consent</B></p><BR>
					  <p>By using our web site, you consent to the collection and use of this information by Signature Fundraising Inc.. If we amend our Privacy Policy, we will immediately post the changes on this page so that you are always aware of what information we gather, how we use it, and under what circumstances we disclose it. We suggest that you check this page on occasion to keep up with the most current policies.</p><BR>
					  
					 <?php } else { ?> 
					  <p> <B>Returns and Refunds</B></p><BR>
					  <p>Signature Fundraising inc. is happy to issue a  refund.
                
To return an item, please follow these simple steps:<BR>
<BR>
                
&nbsp;&nbsp;&nbsp;&nbsp;1. Repack the gift in its original packing, if possible, with the packing slip.<BR><BR>
                
&nbsp;&nbsp;&nbsp;&nbsp;2. GR Number: GR7473 <BR>
<BR>
                
&nbsp;&nbsp;&nbsp;&nbsp;3. Ship to:<BR><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature Fundraising Inc.<BR>
                
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;42850 Signature Court<BR>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lancaster, CA 93535<BR><BR>
                
For your security, please return your gift with an insured courier (e.g., FedEx, UPS) and retain your receipt. Signature Fundraising Inc. is not responsible for items damaged or lost in transit. We do not refund return shipping cost.
                
<BR><br />
					  <p><B>Shipping Methods</B></p><BR>
					  <p>Signature Fundraising Inc. uses UPS 5-7 business days Ground Services at a flat rate of $7.00 within the country.</p><BR>
					  <p><B>Tell Us What You Think</B></p><BR>
					  <p>Send us an e-mail at <a href="mailto:info@sigfund.com">info@Sigfund.com</a>. We welcome any ideas, questions, and comments regarding Privacy and Your Information.</p>
					  <BR>
					  <p><B>Contact Us on Paper</B></p><BR>
					  <p>Signature Fundraising® <BR>42850 Signature Court<BR>
                          Lancaster, CA 93535 </p>
						  <?php } ?>
					</td>
					<td width="15%">
	  		
				  </td>
    </tr>
				</table>
					
		<table style="margin-top:30px"  width="100%" border="0">
					<tr>
						<td   colspan="2"  valign="bottom">
							<?php /*<p><a href="./<?php echo PROD_IDX."?view=1"; ?>"> <img src="images/CONTINUE-SHOPPING.jpg" /> </a></p> */ ?>
						</td>
					</tr>
		</table>


			
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>