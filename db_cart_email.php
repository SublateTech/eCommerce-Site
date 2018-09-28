<?php 

if (!session_id()) session_start();
require("db_cart_class.php");
require("db_cart_init.php");
require("page.php");
require("db_cart_box.php");
$page_cnt = new Content();
$page_htm = new page();
$page_box = new boxstd();

	
if (isset($_REQUEST["cust_id"]))
	{
	// create a new cart object
	$cust_no = $_REQUEST['cust_id'];
	
	} else
			$cust_no = 0;

$myConfirm = new db_cart($cust_no);

if ( isset($_REQUEST["fname"]) and isset($_REQUEST["lname"]))
	{
			if ($myConfirm->get_customer_by_names($_REQUEST["fname"], $_REQUEST["lname"]))
				{
				$cust_no = $_SESSION['cust_id'];
				$myConfirm = new db_cart($_SESSION['cust_id']);
				
				}
			else
			{	
				print "Doesn't exist";
				exit();
				}
				
	}
	


	
if ( isset($_REQUEST["email"]))
	{
			if ($myConfirm->get_customer_by_email($_REQUEST["email"]))
				{
				$cust_no = $_SESSION['cust_id'];
				$myConfirm = new db_cart($_SESSION['cust_id']);
				
				}
			else
			{	
				print "Doesn't exist";
				exit();
				}
			
				
	}



$num=0;
if (isset($_SESSION['order_id']))
	{
	$order_id = $_SESSION['order_id'];
	$closed = false;
	if ( isset($_REQUEST['num']))
		{
		$num = $_REQUEST['num'];
		$myConfirm->get_closed_order($cust_no,$_REQUEST["num"]);	
		}
	else
		$myConfirm->get_closed_order($cust_no);	
	
	if (!isset($_SESSION['order_id']))
		$_SESSION['order_id'] = $order_id;
	else
		$closed = true;
	
	}

if (isset($_REQUEST["order"]))
	{
	$_SESSION['order_id'] = $_REQUEST["order"];
		
	}

$myConfirm->get_order_by_number($_SESSION['order_id']);	
$cust_no = $_SESSION['cust_id'];
$closed   = ($myConfirm->open=="y"?false:true);

$num_orders = $myConfirm->get_number_of_orders($_SESSION['cust_id']);    

$myConfirm->set_customer_data();
$myConfirm->set_customer_creditcard_data();
$myConfirm->set_shipment_data();



// the next methods are only used to store the data into arrays and variables
if ($closed)
	$myConfirm->show_ordered_rows($_SESSION['order_id']);
else
	$myConfirm->show_ordered_rows();

if ($closed)
	{ 
		$myConfirm->error = "(Order Closed) "."Order: ".$_SESSION['order_id'].""." Customer:".$_SESSION['cust_id'];
	} 
			else
		{
				$myConfirm->error = "(Order Not Closed) "."Order: ".$_SESSION['order_id'].""." Customer:".$_SESSION['cust_id'];
				
		}
		
if (isset($_REQUEST["print"]))
	{
		if ($closed)
		{
			if (isset($_REQUEST["justin"]))
				$myConfirm->check_out("alvaro@sigfund.com");
			else
				$myConfirm->check_out($myConfirm->cust_email); // place here the mail from your customer or a variable
		}
		else
			$myConfirm->error = "We can send confirmation for this order it is not closed";
		
	}


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
	<th  width="50%" align="left" bgcolor="#BBBBBB"  >
			Billing Information:
	</th>
		<th  width="50%" align="left" bgcolor="#BBBBBB" >
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

<td align="left">
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
		 	<td width="50%">
				    <TABLE  align="left" cellSpacing=0 cellPadding=0 width="100%" border=0>
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
											echo "Credit Card Holder:" . $myConfirm->cc_holder."<br>";
											echo "Credit Card Number:" . $myConfirm->cc_number."<br>";
											echo "Credit Card type	:" .$myConfirm->cc_type."<br>";
											echo "Expiration Month	:".$myConfirm->cc_date_month."<br>";
											echo "Expiration Year	:" .$myConfirm->cc_date_year."<br>";
											echo "CVN Number		:".$myConfirm->cc_CVN . "<br>";
											$myConfirm->get_aproval();
											echo "<b>Aproval Code		:".$myConfirm->cc_aproval."</b>";
											echo "<br>Customer		:".$_SESSION['cust_id']. "<br>";	
											echo "Order				:".$_SESSION['order_id']. "<br>";	
											echo "Date Processed	:".$myConfirm->processed_on . "<br>";
											echo "Number of Orders	:".$num_orders. "<br>";									


											if (trim($myConfirm->cc_aproval)!="" && !$closed)
												print "<b><br>Please let know Alvaro to solve this manually...</b>";
												
											
										?>

								
								</td>
							
							</tr>
						
						</TBODY>
					</table>
 <!-- PRINT: stop -->
			</td>

		 	<td valign="top" width="50%">
				    <TABLE   align="left" cellSpacing=0 cellPadding=0 width="100%" border=0>
                          <TBODY>
						  <tr >
								<th  align="left"  colspan="4" bgcolor="#BBBBBB"  >
										Student Information:
								</th>
							</tr>
                        	<tr>
								<td>

							
							<?php 		require("db_cart_student.php");
										$student = new cart_student();
										if ($student->check_return_student()) {
											$student->set_student_data();
											
											$tags = "<br>".$student->student_name;
											$tags .= "<br>".$student->school_name;
											$tags .= "<br>".$student->school_city;
											}
 ?>
							<?php echo $tags; ?>
															
								</td>
							
							</tr>
						
						</TBODY>
					</table>
 <!-- PRINT: stop -->
			</td>

		</tr>

	<tr>
			<td colspan="3" >
				<table  style="margin-top:20px" align="center" width="98%" border="0">
					<tr>
						<td   colspan="4"   align="right" valign="bottom">
							<p><a href="<?php echo $_SERVER['SCRIPT_NAME']."?order=".$_SESSION['order_id']."&num=".$num."&print"; ?>"> Send Confirmation </a></p>
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
			//	$myConfirm->close_order();
				
			}
	}
?>

<?php $page_box->Footer(); ?>
<?php $page_htm->ShowHeader(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
