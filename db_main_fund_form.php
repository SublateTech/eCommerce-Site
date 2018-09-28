<?php

if (!session_id()) session_start();
require_once('classes/sec_class_inc.php');
require_once("db_cart_form_class.php");
$frobj = new db_cart_form_class(); 
if (!$frobj->validate('fund_form'))
	{
			$_OK = false;
	}else
		$_OK = true;



	require("db_main_init.php");
	require("page.php");
	require("db_cart_box.php");
	$page_cnt = new Content();
	$page_htm = new page();
	$page_box = new boxstd();

 	$page_htm->ShowHeader(); 
	$page_cnt->menu = false;
	$page_cnt->Header(); 
 	$page_cnt->Header_Center(); 
 	$page_box->Header(); 
	?>	


	
 

	<table   cellpadding="0"  cellspacing="0" width="100%" align="center" border="0">	
			<?php
		?>

 		<tr > 
		
			<td  align="center" colspan="4"> 	
				
			</td>
		</tr>
	 <tr>
		<td>
			<table  width="90%"  cellpadding="0"  cellspacing="0" align="center" border="0">
								
					<?php 
				echo $frobj->form_start('form1', 'db_main_fund_form.php', 'error', false);	
			//	if (!isset($_SESSION['user']))
			//		{
					?>
					
					<tr>
						<td colspan="4">
	  						<div id='center_title'>
	 						<font size="+1">  SIGNATURE FUNDRAISING FORM  </font>
	 						<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
							</div>
						</td>
					</tr>	
					<tr>
						<td colspan="4">
			 				<div id="error">
								<?php echo $frobj->error; ?> 				
			 				</div>
						</td>
					</tr>
					<?php
					if ($_OK) {		// Comprobamos que ya se haya enviado el formulario

							#To - Name, To - Email, From - Name, From - Email
							$sec = new sec("Signature Fundraising Info", "info@sigfund.com",$_POST['b_firstname']." ".$_POST['b_lastname'], $_POST['b_email']);

							#produce message in html format
							$message = "First Name		:".$_POST['b_firstname']."<br />\n";
							$message .= "Last Name		:".$_POST['b_lastname']."<br />\n";
							$message .= "School Name	:".$_POST['b_school']."<br />\n";
							$message .= "Email Address	:".$_POST['b_email']."<br />\n";
							$message .= "Phone Number	:".$_POST['b_phone']."<br />\n";
							$message .= "Address		:".$_POST['b_address']."<br />\n";
							$message .= "Address2		:".$_POST['b_address2']."<br />\n";
							$message .= "City			:".$_POST['b_city']."<br />\n";
							$message .= "State			:".$_POST['b_state']."<br />\n";
							$message .= "Zip Code 		:".$_POST['b_zipcode']."<br />\n";
							$message .= "Fundraiser		:".$_POST['b_fund']."<br />\n";
							$message .= "\n";


							#build the message with the message title and message content
							$sec->buildMessage('WEB Request Information Message', $message);
	
							#build and send the email
							if($sec->sendmail()) {
									echo 'Your Email Was Sent';
							} else {
									echo 'Your Email Failed to be Sent';
								}

	
					}
						
		  		
						echo $frobj->input_text('First Name:','b_firstname', '', '', isset($_POST['b_firstname'])?$_POST['b_firstname']:'', 30, true);
						echo $frobj->input_text('Last Name:','b_lastname','', '', isset($_POST['b_lastname'])?$_POST['b_lastname']:'', 30, true);
						echo $frobj->input_text('School Name	:','b_school','', '', isset($_POST['b_school'])?$_POST['b_school']:'', 35, false);
						echo $frobj->input_text('Email  Address:','b_email','', '', isset($_POST['b_email'])?$_POST['b_email']:'', 35, true);
						echo $frobj->input_text('Phone Number:','b_phone','', '', isset($_POST['b_phone'])?$_POST['b_phone']:'', 25, false);
						echo $frobj->input_text('Address:','b_address','', '', isset($_POST['b_address'])?$_POST['b_address']:'', 35, false);
  						echo $frobj->input_text('Address2:','b_address2','', '', isset($_POST['b_address2'])?$_POST['b_address2']:'', 35);
						
						echo $frobj->input_text('City:','b_city','','',isset($_POST['b_city'])?$_POST['b_city']:'', 25, false);
						//echo $frobj->input_text('State :','b_state','','',$myCheckout->cust_state, 25, true);
						$ar = array('AL', 'AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS',  
						'MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV',
						'WI','WY');
						
 						echo $frobj->select_list('State :','b_state', isset($_POST['b_state'])?$_POST['b_state']:'', $ar, true, false);
						echo $frobj->input_text('Zip Code:','b_zipcode','','',isset($_POST['b_zipcode'])?$_POST['b_zipcode']:'', 10, false);
						
						$ar = array('Spring Catalog Fundraiser','Fall Catalog Fundraiser','Cookie Dough Fundraiser','Magazine Fundraiser','Holiday Shop Fundraiser',
						'Dollar Bar Fundraiser');
						//echo $frobj->Check_button('b_ship', 'Billing same as Shipping Information',false,'',"onclick=show(true,'d_ship');");
						echo $frobj->select_list('Type of fundraiser :','b_fund', isset($_POST['b_fund'])?$_POST['b_fund']:'', $ar, true, true);
						
				
				?>						
				<?php
				echo "<tr><td  colspan=2 align='center' colspan='1'>";
  				echo "<p class='label'>".$frobj->form_end(true,'','Submit')."</p>";
				echo '</td></tr>';
				
				?>
				
				<tr>

							
			<td colspan="3" >
				<table  width="100%" border="0">
					<tr>
						<td   colspan="4"  valign="bottom">
						
										<?php
									
									/*<p><a  href='#' onclick='document.form1.submit_form.click()'> <img  src="images/CONTINUE-SHOPPING.jpg" /> </a></p>*/
									
									
								
								?>
						</td>
						<td   valign="bottom"  align="right">
									<?PHP /*<p><a  href='#' onclick='document.form1.submit_form.click()'> <img  src="images/CHECKOUT.jpg" /> </a></p>*/?>
							<?php 
									
								//onMouseover='windows.status=";"'
								//onClick="document.form1.form_submit.click();" ?>
							
						</td>
					</tr>
				</table>
				
			</td>
		</tr>

				  	</table>
  				</td>
  			</tr>
		</table>


<?php
//} 
?>
<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
