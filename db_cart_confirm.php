<?php 
require("db_cart_class.php");
require("db_cart_init.php");
require("page.php");
require("db_cart_box.php");
$page_cnt = new Content();
$page_htm = new page();
$page_box = new boxstd();


$order_id = $_SESSION['order_id'];	
// create a new cart object
$cust_no = $_SESSION['cust_id'];
$myConfirm = new db_cart($cust_no, $order_id);

$_SESSION['order_id'] = $order_id;

if (!isset($_REQUEST['Print']))
{
if ($myConfirm->get_number_of_records($order_id) == 0)
{
	header("Location: ".PROD_IDX);
	exit;

}
 
if (!isset($_SESSION['payment']))
		{
		header ("Location: ".CREDITCARD);
		exit;
		}
}
$myConfirm->set_customer_data();
$myConfirm->set_customer_creditcard_data();
$myConfirm->set_shipment_data();

$myConfirm->check_out($myConfirm->cust_email); // place here the mail from your customer or a variable

// the next methods are only used to store the data into arrays and variables
$myConfirm->show_ordered_rows($order_id);
// add here extra data like total or vat if you like

?>

<?php $page_htm->ShowHeader(); ?>
<?php $page_cnt->menu = false;
	  $page_cnt->Header(); ?>
<?php $page_cnt->Header_Center(); ?>
<?php $page_box->Header();  ?>

<!-- PRINT: start -->
<table align="center" width="95%">
<tr>
<td>

<table  width="100%"  cellpadding="0" cellpadding="0" border="0">
	<tr> 
		<td align="center" colspan="6"> 	
			<img  style="margin-top:35px; "  src="images/header_4.jpg" />
		</td>
	</tr>
	<tr>
		<td align="center" colspan="6">
			 <div id="error">
			 		<?php echo $myConfirm->error; ?>
			 </div>
		</td>
	</tr>

	
	<tr>
		<td colspan="6">
	  	<div id='center_title'>
	 		<font size="+1">  ORDER SUMMARY </font>
	 		<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
		</div>
		  
		</td>
	</tr>	

<tr>

  <td align="left" >
    <th   height="25"   align="left">Item #</th>
    <th   align="left">Product</th>
	<th   align="right">Quantity</th>
	<th   align="right">Price</th>
	<th   align="right">Amount</th>
  </td>
 </tr>
 
  <?php 
  		 $subtotal = 0.00;
 		foreach ($myConfirm->order_array as $val) { ?>
	  	<tr>
    		<td colspan="2"align="center"><?php echo $val['product_id']; ?></td>
			<td align="left"><?php echo $val['product_name']; ?></td>
			<td align="right"><?php echo $val['quantity']; ?></td>
			<td align="right"><?php echo $myConfirm->format_value($val['price']); ?></td>
			<td align="right"><?php echo $myConfirm->format_value($val['price'] * $val['quantity']); ?></td> 
			<?php $subtotal += $val['price'] * $val['quantity']; ?>
			
  	</tr>
  <?php } // end foreach loop 
  
  $total = $subtotal + $myConfirm->show_total_shipping();
  
  
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
  	 <b><?php echo $myConfirm->format_value($myConfirm->show_total_shipping()); ?></b>
   </td>
  </tr>
  
     <tr>
    <td  colspan="5" align="right">
  	<b style="color:#FF0000" >Total:</b>
  </td>
      <td align="right">
  	   	 <font style="color:#FF0000" > <b><?php echo $myConfirm->format_value($total); ?></b> </font>
   </td>

  </tr>


  
<tr height="10px">
	<td>
	</td>
</tr>
</table>


<TABLE  border="0" cellSpacing=0 cellPadding=0 width="100%" >

<tr>
	<th  align="left" bgcolor="#BBBBBB"  >
			Billing Information:
	</th>
		<th  align="left" bgcolor="#BBBBBB" >
			Will be shipped to:
	</th>

</tr>
<tr>
<td >
<?php
	echo "Name		: ".$myConfirm->cust_firstname." ".$myConfirm->cust_lastname."<br>";
	echo "Address	: ".$myConfirm->cust_address."<br>";
	print $myConfirm->cust_address2."<br>";
	echo $myConfirm->cust_city.", ".$myConfirm->cust_state."     ".$myConfirm->cust_zipcode."<br>";
	echo "Email		: ".$myConfirm->cust_email."<br>";
	echo "Phone		: ".$myConfirm->cust_phone;
?>
</td>

<td>
<?php
echo $myConfirm->ship_name." ".$myConfirm->ship_name2."<br>";;
echo $myConfirm->ship_address."<br>";
echo $myConfirm->ship_address2."<br>";
echo $myConfirm->ship_city.", ".$myConfirm->ship_state."   ".$myConfirm->ship_zipcode."<br>";
echo "<br>";
print $myConfirm->ship_phone;
?>
</td>
</tr>
<br>
<br>
</table>

 <TABLE  style="margin-top:10px" cellSpacing=0 cellPadding=0 width="100%" border=0>
         <tr>
		 	<td width="100%">
				    <TABLE  align="center" cellSpacing=0 cellPadding=0 width="100%" border=0>
                          <TBODY>
						  <tr>
								<th  align="left"  colspan="4" bgcolor="#BBBBBB"  >
										Credit Card Information:
								</th>
							</tr>
                        	<tr>
								<td>
									<?php
											$myConfirm->set_customer_creditcard_data();
											echo "Credit Card Number:" . "XXXX-XXXX-XXXX-".substr($myConfirm->cc_number,strlen($myConfirm->cc_number)-4)."<br>"; 
											echo "Credit Card type	:" .$myConfirm->cc_type."<br>";
											//echo "Expiration Month	:".$myConfirm->cc_date_month."<br>";
											//echo "Expiration Year	:" .$myConfirm->cc_date_year."<br>";
											//echo "CVN Number		:".$myConfirm->cc_CVN . "<br>";
											
										?>

								
								</td>
							
							</tr>
						
						</TBODY>
					</table>
 <!-- PRINT: stop -->

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
	</tr> */ ?>
	</td>
	</tr>       
	<tr>
			<td colspan="3" >
				<table  style="margin-top:20px" align="center" width="98%" border="0">
					<tr>
						<td   colspan="4"  valign="bottom">
							<p><a href="./<?php echo PROD_IDX; ?>"> <img  src="images/CONTINUE-SHOPPING.jpg"/> </a></p>
						</td>
						<?php /*
						<td   valign="bottom"  align="right">
							<p><a href="classes/print.php" target="_blank" > <img   src="images/CHECKOUT.jpg"   /> </a></p>
						</td>  */?>
						
					</tr>
				</table>
				
			</td>
		</tr>

</TABLE>
</td>
</tr>
</table>

<?php 
// IMPORTANT !
// after all destroy the session
if (isset($_SESSION['testing_mode']) && $_SESSION['testing_mode'] == 'on')
	{
		print "testing proccesing...";
	} else
	{	
		if (!isset($_REQUEST['Print']))
			{
				unset($_SESSION['payment']);
				unset($_SESSION['shipping']);
				unset($_SESSION['order_id']);
				//$myConfirm->close_order();
				
			}
	}
?>

<?php $page_box->Footer(); ?>
<?php $page_htm->ShowHeader(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
