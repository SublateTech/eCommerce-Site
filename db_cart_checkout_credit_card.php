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

if (isset($_REQUEST['cvn'])) 
	{
		ShowCVN();
	?>
	<?PHP
	die();
	}


if (!isset($_SESSION['shipping']) )
	{
		header("Location: ".SHIPPING);
		exit;
	}else if (!$_SESSION['shipping'] == "OK")
	{
		header("Location: ".SHIPPING);
		exit;
	}

$cust_no = $_SESSION['cust_id'];
$myConfirm = new db_cart($cust_no);
if (!$myConfirm->get_number_of_records() > 0)
{
	header("Location: ".PROD_IDX."?action=checkout");
	exit;
}

require_once("db_cart_form_class.php");
$frobj = new db_cart_form_class(); 

if ($frobj->validate('checkout_creditcard'))
	{
		if (isset($_SESSION['testing_mode']) && $_SESSION['testing_mode'] == 'on')
			{
				$myConfirm->close_order();		
				//print "testing proccesing...";
				header("Location:  ". CONFIRM);
				exit;
			} 	
			else
			{
			/*		
			?> <script language="javascript" src="../classes/progressbar.js">
				   </script>
			<?php
			*/
			if ($myConfirm->aproved_creditcard())
				{	
				$myConfirm->close_order();		
				header("Location:  ". CONFIRM);
				exit;
				}else
				$myConfirm->error = "Your credit card was not approved, please check your credit card infomation or use another Visa or Master Card";
			}			
	}
else
	{

	// create a new cart object

	if (!$myConfirm->check_return_creditcard())
		{	
		//echo $myConfirm->error;	
		$myConfirm->get_creditcard();
		}
	$myConfirm->set_customer_data();
	$myConfirm->set_customer_creditcard_data();
	$myConfirm->set_shipment_data();

	// the next methods are only used to store the data into arrays and variables
	$myConfirm->show_ordered_rows();

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

	
	<table  width="96%"  align="center" cellpadding="0" cellpadding="0" border="0">
		<tr> 
			<td   align="center" colspan="6"> 	
				
				<img style="margin-top:35px;" src="images/header_3.jpg" USEMAP = #imagemap />
				<MAP NAME="imagemap">
					<AREA SHAPE="rect" COORDS = "30, 25, 185, 80" HREF="db_cart_login.php"/>
					<AREA SHAPE="rect" COORDS = "190, 25, 345, 80" 	HREF="db_cart_checkout_shipping.php"/>
					<AREA SHAPE="rect" COORDS = "350, 25, 500, 80"  HREF="db_cart_checkout_credit_card.php"/>
				</MAP>

				
			</td>
		</tr>
		<tr>
			<td colspan="6">
				 <div id="error">
			 		<?php echo $myConfirm->error; ?>
					<?php echo $frobj->error; ?>

				 </div>
			</td>
		</tr>
		<tr>
			<td colspan="6">
	  			<div id='center_title'>
	 				<font size="+1">  PAYMENT INFORMATION </font>
	 				<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
				</div>
		</td>
		</tr>	

		<tr>
  			<td  bgcolor="#BBBBBB" align="left" >
    			<th bgcolor="#BBBBBB"  height="25"   align="left">Art. no.</th>
    			<th bgcolor="#BBBBBB"   align="left">Product</th>
				<th  bgcolor="#BBBBBB"  align="right">Quantity</th>
				<th  bgcolor="#BBBBBB"  align="right">Price</th>
				<th  bgcolor="#BBBBBB"  align="right">Amount</th>
  			</td>
  		</tr>
 
  		<?php foreach ($myConfirm->order_array as $val) { ?>
	  		<tr>
    			<td colspan="2"align="center"><?php echo $val['product_id']; ?></td>
				<td align="left"><?php echo $val['product_name']; ?></td>
				<td align="right"><?php echo $val['quantity']; ?></td>
				<td align="right"><?php echo $myConfirm->format_value($val['price']); ?></td>
				<td align="right"><?php echo $myConfirm->format_value($val['price'] * $val['quantity']); ?></td>
			</tr>  	<?php } // end foreach loop 
  
  		$subtotal = $myConfirm->show_total_value();
  		$total = $myConfirm->show_invoice_value();
  		$shipping = $myConfirm->show_total_shipping();
  		$discount = $myConfirm->show_discount_value();
  		$myConfirm->update_order_totals($myConfirm->subtotal, $myConfirm->discount, $myConfirm->ship_price, $myConfirm->total);
  
  
  		?>
  
 		 <tr>
   			<td  colspan="5"align="right">
  				<b>Subtotal:</b>
   			</td>
    		<td align="right">
  	 			<b><?php echo $myConfirm->format_value($subtotal); ?></b>
   			</td>
  		</tr>
  		<tr>
    		<td  colspan="5" align="right">
  				<b>Shipping:</b>
  			</td>
      		<td align="right">
  	 			<b><?php echo $myConfirm->format_value($shipping); ?></b>
   			</td>
  		</tr>
  <?php 
  	if ($discount >0)
  	{
	?>
  <tr>
    <td  colspan="5" align="right">
  	<b>Discount:</b>
  	</td>
      <td align="right">
  	 <b><?php echo $myConfirm->format_value($discount); ?></b>
   	</td>
  </tr>
	<?php } ?>
  
     <tr>
    <td  colspan="5" align="right">
  	<b style="color:#FF0000">Total:</b>
  </td>
      <td align="right">
  	   	 <b style="color:#FF0000" ><?php echo $myConfirm->format_value($total); ?></b>
   </td>

  </tr>
 
</table>


<TABLE  border="0" cellSpacing=0 cellPadding=0 width="96%"  align="center" >

	<tr>
		<th  align="left" height="25" bgcolor="#BBBBBB"  >
			Billing Information:
		</th>
		<th  align="left" bgcolor="#BBBBBB" >
			Will be shipped to:
		</th>

	</tr>
	<tr>
	<td  >	
		<?php
			echo $myConfirm->cust_firstname."<br>";
			echo $myConfirm->cust_lastname."<br>";
			echo $myConfirm->cust_address."<br>";
			echo $myConfirm->cust_address2."<br>";
			echo $myConfirm->cust_city." ".$myConfirm->cust_zipcode."<br>";
			echo $myConfirm->cust_state;
	   	?>
	</td>
	
	<td>
	<?php
	echo $myConfirm->ship_name."<br>";
	echo $myConfirm->ship_name2."<br>";
	echo $myConfirm->ship_address."<br>";
	echo $myConfirm->ship_address2."<br>";
	echo $myConfirm->ship_city." ".$myConfirm->ship_zipcode."<br>";
	echo $myConfirm->ship_state;
	?>
	</td>
	</tr>
	
	<tr>
			<td align="center">
	 		 	<a  href="db_cart_checkout_shipping.php">Change/Add</a>
			</td>
			<td align="center">
	 		 	<a  href="db_cart_checkout_shipping.php">Change/Add</a>
			</td>
	</tr>
	<br>
	<br>
</table>


  <TABLE  style="margin-top:0;"  cellSpacing=0 cellPadding=0 width="96%"  align="center" border="0">
         
						  <tr>
								<th  align="left"  colspan="2" >
										Credit Card Information:
								</th>
							</tr>

                          <TR>
						    <Td colspan="3" align="center"  width="100%">
							  		<B>Accepted Credit Cards : </B><br />
							  <IMG  src="images/visa.gif">
							 </td>
						</TR>
						<TR height="20px">
                           <td colspan="2">
						   		<?php 
																					
								echo $frobj->form_start('form2', 'db_cart_checkout_credit_card.php', 'error', false);
								
								echo $frobj->input_text('Credit Card Number:','number', '', '', $myConfirm->cc_number, 30, true);
								echo $frobj->input_text('Full Name as it appears on the  card:','holder', '', '', $myConfirm->cc_holder, 30, true);		
								echo $frobj->input_text("CVN :<a  href=javascript:NewWindow('db_cart_checkout_credit_card.php?cvn','',450,430,'')><img src='images\mini_cvv2.gif' /> What's this?</a> ","CVN", '', '', $myConfirm->cc_CVN, 6, true);
								
								$ar = array('01-Jan','02-Feb','03-Mar','04-Apr','05-May','06-Jun','07-Jul','08-Aug','09 Sep','10-Oct','11-Nov','12-Dec');
 								echo $frobj->select_list('Expiration Month:','exp_month', $myConfirm->cc_date_month, $ar, false, true);
								
								$ar = array('2007','2008','2009','2010','2011','2012','2013','2014');
 								echo $frobj->select_list('Expiration Year:','exp_year', $myConfirm->cc_date_year, $ar, true, true);

								echo "<tr><td align='center' colspan='0'>";
				  				if (!($browser[0]==5 && $browser[1] <= 5))	//IE 5.0
									echo "<p class='label'>".$frobj->form_end()."</p>";
								else
									echo "<p  class='label'>".$frobj->form_end(true,'submit_form','Order Now!')."</p>";
								
								
								echo '</td></tr>';
								
						   		?>
						   </td>
											  							 
                          </TR>
					
<?php /*				
	<tr>
		<td colspan="3" >
				<table  width="100%"  height="20" border="0" cellpadding="0"  cellspacing="0" >
					<tr>
						<td align="right">
							
							<?php echo ($myConfirm->ship_msg != "") ? "<p><b>The message:</b><br>".nl2br($myConfirm->ship_msg)."</p>" : ""; ?>
													
						</td>
					</tr>	
				</table>
		</td>
	</tr> */?>

	<tr>
			<td colspan="3" >
				<table  width="100%" border="0">
					<tr>
						<td   colspan="4"  valign="bottom">
							<p><a href="./<?php echo PROD_IDX; ?>"> <img src="images/CONTINUE-SHOPPING.jpg" /> </a></p>
						</td>
						<td   valign="bottom"  align="right">
						<?php
							if (!($browser[0]==5 && $browser[1]<=5))	//IE 5.0
									{
									?>
									<p><a onClick="document.form2.submit_form.click();" href="#"> <img  src="images/ORDER NOW.jpg"  /> </a></p>
								<?php
									}
								?>
								
						</td>
					</tr>
				</table>
				
			</td>
		</tr>

</TABLE>

<?php $page_box->Footer(); ?>
<?php $page_htm->ShowHeader(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
<?php

 function showCVN()
	 {
	 
		?>
			 	<table  align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center">
							  			<img  src="/images/CVN.jpg" /> 
																																	
								 	</td>
								</tr>
								 <tr>
								 	<td align="center">
										<TR>
												<TD align="center">
												<br />
												<form action="#">
												<div>
												<input type="button" name="but" id="but" onClick="window.close();" value="Close Window"></input>
												</div>
												</form>
												</TD>
										</TR>

									</td>
								 </tr>
							 </table>
						
		<?php 
        return;
    } 


?>

