<?php

require_once("db_cart_functions.php");

$browser = GetBrowser();
if (!($browser[0]==5 && $browser[1]<=5))	//IE 5.0
	{
		if($_SERVER['HTTPS'] !== "on")
			{
	 			header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
	 			exit;
			}
	}

require("db_cart_class.php");

$cust_no = $_SESSION['cust_id'];
$myCheckout = new db_cart($cust_no);

require("db_cart_form_class.php");
$frobj = new db_cart_form_class(); 

if ($frobj->validate('shipment'))
	{
			header("Location:  ". CREDITCARD);
			exit;
	}
else
	{
	
		$myCheckout->set_customer_data();
		if (!$myCheckout->check_return_shipment())
	 		{
	 			$myCheckout->set_customer_ship();
	 			$myCheckout->update_shipment($myCheckout->cust_firstname, $myCheckout->cust_lastname, $myCheckout->cust_address, $myCheckout->cust_address2, $myCheckout->cust_zipcode,$myCheckout->cust_city, $myCheckout->cust_state, $myCheckout->cust_phone,  "");
	 		}

					//Make shure that Shipment Info exist

					$myCheckout->set_shipment_data();
					$myCheckout->set_customer_data();

					}
		


	require("db_cart_init.php");
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
		if ($myCheckout->get_number_of_records() > 0)
		{
		//	header("Location: ".PROD_IDX);
		?>

 		<tr > 
		
			<td  align="center" colspan="4"> 	
				<img style="margin-top:35px;" src="images/header_2.jpg" USEMAP = #imagemap />
				<MAP NAME="imagemap">
					<AREA SHAPE="rect" COORDS = "30, 25, 185, 80" HREF="db_cart_login.php"/>
					<AREA SHAPE="rect" COORDS = "190, 25, 345, 80" 	HREF="db_cart_checkout_shipping.php"/>
					<AREA SHAPE="rect" COORDS = "350, 25, 500, 80"  HREF="db_cart_checkout_credit_card.php"/>
				</MAP>


			</td>
		</tr>
		<?php } ?>
	 <tr>
		<td>
			<table  width="90%"  cellpadding="0"  cellspacing="0" align="center" border="0">
								
					<?php 
				echo $frobj->form_start('form1', 'db_cart_checkout_shipping.php', 'error', false);	
			//	if (!isset($_SESSION['user']))
			//		{
					?>
					
					<tr>
						<td colspan="4">
	  						<div id='center_title'>
	 						<font size="+1">  BILLING INFORMATION </font>
	 						<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
							</div>
						</td>
					</tr>	
					<tr>
						<td colspan="4">
			 				<div id="error">
			 				<?php echo $myCheckout->error; ?>
							<?php echo $frobj->error; ?>
			
			 				</div>
						</td>
					</tr>
					<?php
		  		
						echo $frobj->input_text('First Name:','b_firstname', '', '', $myCheckout->cust_firstname, 30, true);
						echo $frobj->input_text('Last Name:','b_lastname','', '', $myCheckout->cust_lastname, 30, true);
						echo $frobj->input_text('Email  Address:','b_email','', '', $myCheckout->cust_email, 35, true);
						echo $frobj->input_text('Phone Number:','b_phone','', '', $myCheckout->cust_phone, 25, true);
						echo $frobj->input_text('Billing Address:','b_address','', '', $myCheckout->cust_address, 35, true);
  						echo $frobj->input_text('Billing Address2:','b_address2','', '', $myCheckout->cust_address2, 35);
						
						echo $frobj->input_text('City:','b_city','','',$myCheckout->cust_city, 25, true);
						//echo $frobj->input_text('State :','b_state','','',$myCheckout->cust_state, 25, true);
						$ar = array(' ','AL', 'AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','GU','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS',  
						'MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV',
						'WI','WY');
						
												/*$ar = array("Alabama", "Alaska", "APO", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", 
"Illinois", "Indiana", "Iowa",  "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", 
"Hampshire 'New Jersey'", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio, Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", 
"Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"); */
 						echo $frobj->select_list('State :','b_state', $myCheckout->cust_state , $ar, true, true);
						echo $frobj->input_text('Zip Code:','b_zipcode','','',$myCheckout->cust_zipcode, 10, true);
						echo $frobj->Check_button('b_ship', 'Shipping Information is the same as Billing Information',false,'',"onclick=show(true,'d_ship');");
						
				//	}
					
				  ?>
				  
				<div id='d_ship'>
  				<tr >
					<td colspan="4">
	  					<div id='center_title'>
	 					<font size="+1">  SHIPPING INFORMATION </font>
	 					<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
						</div>
					</td>
				<tr>	
					<td valign="top" align="center" colspan="4">
	  					<font color="#000099" size="2">  We cannot ship to PO Boxes. Please only enter a physical delivery address.</font>
	 					<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
					</td>
					<td>
						
					</td>
					
				</tr>	
				</div>
				<?php
				
						echo $frobj->input_text('First Name:','firstname', '', '', $myCheckout->ship_name, 30, true);
						echo $frobj->input_text('Last Name:','lastname','', '', $myCheckout->ship_name2, 30, true);
						echo $frobj->input_text('Phone Number:','phone','', '', $myCheckout->ship_phone, 25, true);
						echo $frobj->input_text('Shipping Address:','address','', '', $myCheckout->ship_address, 35, true);
						echo $frobj->input_text('Shipping Address2:','address2','', '', $myCheckout->ship_address2, 35);
						echo $frobj->input_text('City:','city','','',$myCheckout->ship_city, 25, true);
						//echo $frobj->input_text('State :','b_state','','',$myCheckout->ship_state, 25, true);
						/*$ar = array("Alabama", "Alaska", "APO", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", 
"Illinois", "Indiana", "Iowa",  "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", 
"Hampshire 'New Jersey'", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio, Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", 
"Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming");*/
						$ar = array('AL', 'AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','GU','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS',  
						'MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV',
						'WI','WY');
 						echo $frobj->select_list('State :','state', $myCheckout->ship_state , $ar, true, true);
						echo $frobj->input_text('Zip Code:','zipcode','','',$myCheckout->ship_zipcode, 10, true);

				?>						
				<?php
				echo "<tr><td  colspan=2 align='center' colspan='1'>";
  				if (!($browser[0]==5 && $browser[1]<=5))	//IE 5.0
					echo "<p class='label'>".$frobj->form_end()."</p>";
				else
					echo "<p class='label'>".$frobj->form_end(true,'submit_form','Continue Check Out')."</p>";
					
				echo '</td></tr>';
				
				?>
				
				<tr>

							
			<td colspan="3" >
				<table  width="100%" border="0">
					<tr>
						<td   colspan="4"  valign="bottom">
						
						<?php if ($myCheckout->get_number_of_records() == 0)
									{
									/*	<p><a href="./<?php echo PROD_IDX; ?>"> <img src="images/CONTINUE-SHOPPING.jpg" /> </a></p> */ 
									?>
									<p><a  href='#' onclick='document.form1.submit_form.click()'> <img  src="images/CONTINUE-SHOPPING.jpg" /> </a></p>
									<?php
									}
								
								?>
						</td>
						<td   valign="bottom"  align="right">
							<?php if ($myCheckout->get_number_of_records() > 0)
									{
										if (!($browser[0]==5 && $browser[1]<=5))	//IE 5.0
											{
									 		?>
												<p><a  href='#' onclick='document.form1.submit_form.click()'> <img  src="images/CHECKOUT.jpg" /> </a></p>
											<?php 
											}
									}
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
