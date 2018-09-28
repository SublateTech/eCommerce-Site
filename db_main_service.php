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

			?>  <table style="margin-top:30px"	  height="304" width="100%" bgcolor="#FFFFFF"> 
				<tr>
					<td height="41"  colspan="4">
					<div id='center_title'>
					<font size="+1">  TOTAL SERVICE PROGRAM </font>
					</div>
					<a name="top"></a>
				  </td>
				</tr>	
					<tr valign="top">
					  <td width="14%" height="243"  align = "justify" ><!--DWLayoutEmptyCell-->&nbsp;</td>
					  <td width="77%" height="243"  align = "CENTER" ><div align="left">
					    <p><FONT face="Arial, Helvetica, sans-serif" size="2"><b><br>
			            <br>
			            Signature Fundraising Inc. helps your fundraiser run smoothly with the following services:</b></FONT><br>
			            <br>
				          <br>
					    <a href="#1"><p>1. Customized Parent Letter</p><br></a>
					    <a href="#2"><p>2. Customized Brochure Packet</p><br></a>
					    <a href="#3"><p>3. Exclusive Kick-Off Assembly</p><br></a>
					    <a href="#4"><p>4. Amount and Reconciliation System</p><br></a>
					    <a href="#5"><p>5. Personal Pick-Up and Checking of Each Order</p><br></a>
					    <a href="#6"><p>6. Customized Individual Student Discrepancy Packet</p><br></a>
					    <a href="#7"><p>7. Individual Student Boxed Order</p><br></a>
					    <a href="#8"><p>8. Customized Delivery of Product</p><br></a>
					    <a href="#9"><p>9. Customer Direct Post Delivery Service </p></a>
					    <p><br>
					      <br>
						<a name='1'><b>Customized Parent Letter</b></a></p><br>
					    <p>We customize a parent letter that you will approve. This letter can be printed in both English and Spanish. We print a letter for each student.</p>
					    <br><br><p><b><a name='2'>Customized Brochure Packet</a></b></p><br>
					    <p>A pre-stapled brochure packet that includes the customized parent letter, brochure, NCR order form, prize brochure, and a money collection envelope for each seller is provided for easy handout to teachers and students.</p>
					    <br><br><p><b><a name='3'>Exclusive Kick-Off Assembly</a></b></p><br>
					    <p>Have you fundraiser started off right with our exclusive video assembly that can be shown school wide, by grade level or individual classes at your convenience. Please ask us for a copy of this video when you call. </p>
					    <br><br><p><b><a name='4'>Amount and Reconciliation System</a></b></p><br>
					    <p>When the order forms and money are turned in, there's no need to verify the amount with the items ordered- we do that for you! All you do is count the money that each student turns in and write it on the students order form in the &quot;School Use Only&quot; box. The order form is three part carbonless so that you and your parent can each keep a copy. </p>
					    <br><br><p><b><a name='5'>Personal Pick Up and Checking of Each Order</a></b></p><br>
					    <p>UPS will personally pick up your order forms on the schedule date and deliver them directly to our offices, where we will enter each students order form into our computers. We will check each order form that has a discrepancy of even 1 cent.</p>
					    <br><br><p><b><a name='6'>Customized Individual Student Discrepancy Packet</a></b></p><br>
					    <p>For each order with a discrepancy of at least $1.50, we will also provide a Discrepancy Packet that includes: </p>
					    <br>
					    <p>- A letter to the parent with a personal note of explanation of the possible reason for the discrepancy&nbsp;&nbsp;with our toll free number to help with the situation.</p>
					    <p>- An additional money collection envelope (if/she owes a balance).</p>
					    <p>- We also include a master list so that you can keep simple records of these situations.</p>
					    <br><p>The packet will be sent to you via Fed/Ex or UPS five to seven days before your delivery of products.</p>
					    <br><br><p><b><a name='7'>Individual Student Boxed Order</a></b></p><br>
					    <p>Each students order is boxed individually for him/her and includes:</p>
					    <br><p>- All products that were sold</p>
					    <p>- His/Her original order form</p>
					    <p>- A packing slip with our toll free 800 number for parents to call with any question they may have.</p>
					    <p>- His/Her prizes earned</p>
					    <br><br><p><b><a name='8'>Customized Delivery of Product</a></b></p><br>
					    <p>The orders are delivered to your group on the promised delivery date as set at the beginning of your sale. Each students box is coded numerically by teacher for easy separation. We can customize the delivery to accommodate your needs; just let us know how we can help. </p>
					    <br><br><p><b><p><a name='9'>Customer Direct Post Delivery Service</a></p></b><br>
					    <p>If parents receive a damaged item or have any questions or problems regarding the order, they instructed to call our toll free 800 number and a new item will be shipped directly to them within 7 business days! You can refer all of these situations to us! You don't have to take time out of your life to deal with these situations. </p>
					     <br><br><p><b>What, you may ask, is there for me to do?</p></b><br>
					     <p>Spend Your Profits!</p>
					     <p>And be a hero for picking the number one fundraising company in America. </p><br><br><br>
						 <font color="#990000">For more information on our <b>Total Service Program</b> please call us toll free at <b>1-800-645-3863</b></font><br><br><br>
					  </div></td>
                      <td width="9%">
	  		    
				      </td>
  </tr>
				</table>
			<?php
				
			$page_box->Footer(); 
			$page_cnt->Footer_Center(); 
			$page_cnt->Footer(); 
			$page_htm->EndPage(); 
		

?>