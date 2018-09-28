<?php 
if (!session_id()) session_start();
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

			?>  <table style="margin-top:30px"	  height="330" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="41"  colspan="4">
					<div id='center_title'>
					<font size="+1">  Frequently Asked Questions (FAQ) </font>
					</div>
					<a name="top"></a>
				  </td>
				</tr>	
					<tr valign="top">
					  <td width="14%" height="243"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td width="71%" height="243"  align = "CENTER" >
					 
					 
					    <div align="left">
					      <br><br>We at <font color="#990000"><b>Signature Fundraising Inc. </b></font>are always looking for a better way to serve our customers. If you have questions other than the questions provided below please feel free to submit a question at any time to <a href="mailto:info@sigfund.com">info@sigfund.com</a>.
						  <br><br><br>
						  <p>Q: Who do I make the check payable to? </p>
			              <p>&nbsp; </p>
			              <p>A: The information needed will be provided in the Parent Letter that is attached to the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;brochure. &nbsp;If the letter is no longer attached, please see the school for this information. </p>
			              <p>&nbsp; </p>
			              <p>Q: Is it possible to order after our school fundraiser has ended? </p>
			              <p>&nbsp; </p>
			              <p>A: Yes. Simply go online to <a href="http://www.sigfund.com/">www.sigfund.com</a> and click on Shop Online. If this isn&rsquo;t available, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;please see the school to check if they are accepting orders turned in late. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I get a copy of your brochure for an upcoming meeting? </p>
			              <p>&nbsp; </p>
			              <p>A: Please call us at <font color="#990000"><b>1-800-645-3863 </b></font>or e-mail us at info@sigfund.com. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I cancel my online purchase? </p>
			              <p>&nbsp; </p>
			              <p>A: Please call us at <font color="#990000"><b>1-800-645-3863</b></font>. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I purchase items online? </p>
			              <p>&nbsp; </p>
			              <p>A: Simply go online to <a href="http://www.sigfund.com/">www.sigfund.com</a> and click on Shop Online. Once you&rsquo;ve filled your &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cart, click Checkout and follow the instructions. </p>
			              <p>&nbsp; </p>
			              <p>Q: Will I get a voucher for the magazines to give to the persons that ordered them? </p>
			              <p>&nbsp; </p>
			              <p>A: If placing an order online, you select the magazine and the shipping address while ordering. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you&rsquo;re ordering from the brochure and writing your order on the order form, you will &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;receive a voucher that gets filled out and mailed to the Publisher Center. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I return a broken item for a new one? </p>
			              <p>&nbsp; </p>
			              <p>A: Please call us at <font color="#990000"><b>1-800-645-3863</b></font> to report a broken item. </p>
			              <p>&nbsp; </p>
			              <p>Q: How long can the cookie dough be left unrefrigerated? </p>
			              <p>&nbsp; </p>
			              <p>A: According to the inside of the Cookie Dough brochure, Cookie Dough keeps refrigerated for &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6 months, frozen for 1 year, &amp; room temperature (66 o-77 o) for 21 days. Cookie Dough &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;may be thawed &amp; refrozen. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I give credit to a student for my order? </p>
			              <p>&nbsp; </p>
			              <p>A: While online in the check out process include the name of the student, the name of the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;school, and the city and state the school is located in. </p>
			              <p>&nbsp; </p>
			              <p>Q: What is your return policy? </p>
			              <p>&nbsp; </p>
			              <p>A: If not satisfied within 30 days of delivery of product, you may return any item for a full &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;refund. Refunds will be paid via mail within 20 days of confirmation that merchandise has &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;been returned to the Organization. In some cases, it will be necessary for you to ship the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;item back at your expense to Signature Fundraising Inc. We will refund shipping costs only &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if the item is a result of our error. No refunds will be given after 30 days beyond delivery of &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;product to the Organization. We cannot exchange an item that was purchased with a &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;different item. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I redeem my gift certificate? </p>
			              <p>&nbsp; </p>
			              <p>A: While online in the check out process include the gift certificate number in the appropriate &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;field. </p>
			              <p>&nbsp; </p>
			              <p>Q: Can I purchase Cookie Dough online? </p>
			              <p>&nbsp; </p>
			              <p>A: At this time we are unable to provide cookie dough over the internet. You may purchase &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;other items on the school&rsquo;s behalf. Simply include the name of the student, the name of the &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;school, and the city and state the school is located in. </p>
			              <p>&nbsp; </p>
			              <p>Q: How long does it take for my online order to arrive? </p>
			              <p>&nbsp; </p>
			              <p>A: You r order will be delivered 5-7 business days after the order is received by Signature. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do I know that my information is safe when purchasing items at your online </p>
			              <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;store? </p>
			              <p>&nbsp; </p>
			              <p>A: Signature Fundraising, Inc. uses Comodo to ensure your billing information is kept private. Please click on the icon to the lower right to see our certificate. </p>
			              <p>&nbsp; </p>
			              <p>Q: How do we direct friends and family to shop on your site? </p>
			              <p>&nbsp; </p>
			              <p>A: You can use our <a href="db_main_tell_a_friend.php" target="page" onClick="window.open('','page','toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=330,height=440,left=50,top=50,titlebar=yes')">Tell Family & Friends Service</a> to do so. </p>
						  <br><br><br>
					    </div></td>
                      <td width="15%">
	  		    
				      </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>