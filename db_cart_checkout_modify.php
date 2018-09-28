<?php


$modify = new cart_modify();

class cart_modify
	{

	var $myCheckout;
	var $frobj;
	var $school_name;
	var $school_city;
	var $student_name;
	var $student;
	var $magazine;
	
	
	function cart_modify()
	{
	
	require("db_cart_class.php");
	$cust_no = $_SESSION['cust_id'];
	//$cust_email = $_SESSION['email'];
	
	require("db_cart_student.php");
	$this->student = new cart_student();

	require_once("db_cart_magazines.php");
	$this->magazine = new cart_magazines();
	
	//echo $this->magazine->error;
	
	
	require_once("db_cart_form_class.php");
	$this->frobj = new db_cart_form_class(); 
	if ($this->frobj->validate(''))
	{
		
		header("Location:  ". CONFIRM);
		exit;
	}
	

	$this->myCheckout = new db_cart($cust_no);
	
	$this->process_pars();
	
	
	if (isset($_SESSION['student_id']))
			$this->student->set_student_data();
	
	
	if (!$this->myCheckout->get_number_of_records() > 0)
		{
		
			header("Location: ".PROD_IDX."?action=checkout");
			
		}
	else 
		 { 

		 // show all rows in this order
		$this->myCheckout->show_ordered_rows();


		require("db_cart_init.php");
		require("page.php");
		require("db_cart_box.php");

		$page_htm = new page();
		$page_cnt = new Content();
		$page_box = new boxstd();

	  	$page_htm->ShowHeader(); 
	  	$page_cnt->menu = false;
	  	$page_cnt->Header(); 
 	  	$page_cnt->Header_Center(); 
 	 	$page_box->Header(); 
		?>

		

	<?php //$page_box->Header(); 
		$this->show_cart(); ?>
	
		<table  align="center" border="0"  cellspacing="0" cellpadding="0" width="90%">
				<tr>
					<td height="30px">
					</td>
				</tr>
		</table>
		<table   align="center" border="0"  cellspacing="0" cellpadding="0" width="90%">
			<tr>
				<td   valign="top" width="50%">
					<?php $this->show_coupon(); ?>
				</td>
				<td width="50%">
					<?php $this->show_afiliates(); ?>
				</td>
							
			</tr>
			
				<?php if ((isset($_GET['action']) && $_GET['action'] == "chgship") || strlen($this->frobj->error) > 10) 
						{
						echo "<tr><td colspan=2 >";
							if (isset($_GET['action']) && $_GET['action'] == "chgship")
								$_SESSION['product_id'] =  $_GET['product_id'];
						$this->change_shipping_address($_SESSION['order_id'],$_SESSION['product_id']);
						echo "</td></tr>";
						}
				?>
	
		</table>

		<table style="margin-top:30px"  width="100%" border="0">
					<tr>
						<td   colspan="2"  valign="bottom">
							<p><a href="./<?php echo PROD_IDX."?view=1"; ?>"> <img src="images/CONTINUE-SHOPPING.jpg" /> </a></p>
						</td>
						<td   valign="bottom"  align="right">
							 <p><a href="./<?php echo LOGIN; ?>" > <img  src="images/CHECKOUT.jpg" /> </a></p> 
							<?php /*
										onClick="document.discount.discount.click();"
										onClick="document.discount.submit();"><img  src="images/CHECKOUT.jpg" /></a> */?>
						</td>
					</tr>
		</table>

<?php //$page_box->Footer(); ?>


<?php $page_box->Footer(); ?>
<?php $page_cnt->Footer_Center(); ?>
<?php $page_cnt->Footer(); ?>
<?php $page_htm->EndPage(); ?>
<?php } // end if cart is not empty ?>


<?php 
}

// Displays alternate table row colors 
function row_color($i)
{ 
    $bg1 = "#EEEEEE"; // color one     
    $bg2 = "#DDDDDD"; // color two 

    if ( $i%2 )  
        return $bg1; 
     else  
        return $bg2; 
    
} 

function show_coupon()
	{
		?>
		<table valign="top" align="center" border="0"  cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<th  align="left" colspan="1" bgcolor="#CCCCCC" >
						<b> DISCOUNTS </b>
				</th>

			</tr>
			<tr>
		
				<td  >
					<b>Enter coupon code: </b>
					<?php 
					
					echo $this->frobj->form_start('form2', 'db_cart_checkout_modify.php', 'error', false);
			
								echo 'Coupon Number: <br>';
								$this->frobj->TextBox('number', '', true, '', 30);
								$this->frobj->Objets['number']->show();

					echo "<tr><td align='center' colspan='0'>";
	  				echo $this->frobj->form_end(true,'discount', 'Apply');
					echo '</td></tr>';
				     ?>
				</td>
				
			</tr>	
			<tr>
				<td>
					Click here to apply discount coupon			
				</td>
			</tr>
				
		
		</table>
	<?php
	
	}
	
function change_shipping_address($order_id='', $product_id='')
	{
		?>
		<table valign="top" align="center" border="0"  cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<th  align="left" colspan="2" bgcolor="#CCCCCC" >
						<b> CHANGE SHIPPING ADDRESS ( <?php echo $_SESSION['product_id']; ?>)</b>
				</th>

			</tr>
			<tr>
		
				<td >
					<b>Shipping Address: </b>
					<?php 
						
						$this->magazine->get_magazine_by_order($_SESSION['order_id'],$_SESSION['product_id']);
						$this->magazine->set_magazine_data_by_order($_SESSION['order_id'],$_SESSION['product_id']);					
					//	require("db_cart_form_class.php");
						$frobj = new db_cart_form_class(); 
						
						
						
						echo $frobj->form_start('form1', 'db_cart_checkout_modify.php', 'error', false);	
						echo '<input type="hidden" name="product_id" value="'. $_SESSION['product_id'].'">';
						echo $frobj->input_text('Full Name:','fullname', '', '', $this->magazine->SUSCRIBERNAME, 40, true);
						echo $frobj->input_text('Phone :','phone','', '', $this->magazine->HOMETELEPHONE, 20, true);
						echo $frobj->input_text('Address 1:','address','', '', $this->magazine->PRIMARYADDRESS, 35, true);
						echo $frobj->input_text('Address 2:','address2','', '', $this->magazine->SECONDARYADDRESS, 35);
						echo $frobj->input_text('City:','city','','',$this->magazine->CITY, 25, true);
						$ar = array('AL', 'AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS',  
						'MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV',
						'WI','WY');
						
 						echo $frobj->select_list('State :','state', $this->magazine->STATE , $ar, true, true);
						echo $frobj->input_text('Zip Code:','zipcode','','',$this->magazine->ZIPCODE, 10, true);

				?>						
				<?php
				echo "<tr><td  colspan=2 align='center' colspan='1'>";
  				echo "<p class='label'>".$frobj->form_end(true,'chgship','Apply')."</p>";
				echo '</td></tr>';

					
				     ?>
				</td>
				
			</tr>	
				
			<?php
				$this->magazine->show_footer();
			?>
		</table>
	<?php
	
	}

	
function show_afiliates()
	{
	?>
		<table  align="center" border="0"  cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<th  align="left" colspan="2" bgcolor="#CCCCCC" >
					<b> Student Credit </b>
				</th>

			</tr>
			<tr>
				<td  style="margin-left:10px; " >
				
					<b>Enter student information: </b> <br><br>
	
					Please enter the Student information below to ensure your Student and your Student's School receive credit for the sale.<br /><br />
					
						<?php 
					
					echo $this->frobj->form_start('form1', '', 'error', false);
			
																
								$this->frobj->Label('Student Name:');
								$this->frobj->TextBox('name', '', true, $this->student->student_name, 30);
								$this->frobj->Objets['name']->show();
								
								$this->frobj->Label('School Name: ');
								$this->frobj->TextBox('school', '', true, $this->student->school_name, 30);
								$this->frobj->Objets['school']->show();
								
								$this->frobj->Label('City,State: ');
								$this->frobj->TextBox('city', '', true, $this->student->school_city, 30);
								$this->frobj->Objets['city']->show();
								
								
								//echo $frobj->input_text('Student Name:','name', '', '', '', 30, false);		
								//echo $frobj->input_text('School Name','school_name', '', '', '', 6, false);
								//echo $frobj->input_text('School City Name','city', '', '', '', 6, false);
															

					echo "<tr><td align='center' colspan='0'>";
	  				echo $this->frobj->form_end(true,'student', 'Apply');
					echo '</td></tr>';					?>
					
				</td>
				<td><br />
					After entering student credit information; click here to apply information for linking the student to this current order, then click checkout.<br /><br />			
				</td>
			</tr>	
		</table>	
	<?php 
	}
	
		
	function show_cart()
		{
		?>
		<table  align="center" border="0"  cellspacing="0" cellpadding="0" width="90%">
			<tr>
				<td  colspan="5">
					<div id='center_title'>
					<font size="+1">  SHOPPING CART </font>
					
				</div>
				</td>
			</tr>	
			<tr>
				<td colspan="6" height="30px" >
						<div id="error">
			 				<?php echo $this->myCheckout->error; ?>
							<?php echo $this->frobj->error; ?>
							<?PHP echo $this->student->error; ?>  
						</div>
				</td>
			</tr>
			
			
			<tr>
				<td colspan="5">
					<h3 style="width:100%;"><span style="float:right;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=cancel">Cancel all!</a> </span> </h3>
				</td>
			</tr>


			  <tr>
				    <th>Item #</th>
				    <th align="left">Product</th>
					<th align="right">Price</th>
					<th align="right">Amount</th>
					<th>Quantity</th>
			</tr>
  <?php 
  $i=0;
  foreach ($this->myCheckout->order_array as $val) { ?>
  <tr>
  
    <?php echo "<td  style='padding-left:10px' width='10%' align='left' bgcolor=".$this->row_color($i).">";?> <?php echo $val['product_id']; ?></td>
	<?php echo "<td width='50%' align='left' bgcolor=".$this->row_color($i).">";?> <?php echo $val['product_name'];
/*	if (substr($val['product_id'],0,1) == 'G')
		{
		echo "<a action='chg_ship' href='db_cart_checkout_modify.php?action=chgship&product_id=".$val['product_id']."'><br>Shipping Address<a>";
		//echo '<br><input type="submit" name="add" value="Shipping Address">';
		}*/ 
	
	 ?></td>
	<?php echo "<td width='10%' align='right' bgcolor=".$this->row_color($i).">";?><?php echo $this->myCheckout->format_value($val['price']); ?></td>
	<?php echo "<td width='10%' align='right' bgcolor=".$this->row_color($i).">";?><?php echo $this->myCheckout->format_value($val['price'] * $val['quantity']); ?></td>
	<?php echo "<td width='20%' align='center'  bgcolor=".$this->row_color($i).">";?>
     <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
	    <input type="hidden" name="row_id" value="<?php echo $val['id']; ?>">
	    <input  type="text" name="quantity" size="5" value="<?php echo $val['quantity']; ?>">
	    <input type="submit" name="add" value="Update">
      </form>
	</td>
  </tr>
  <tr height="1px"></tr>
  <?php
  $i++;
   } // end foreach loop ?>
   <tr>
     <td  valign="top" width="50%" colspan="2">
	 <br />
   	<p>Total value of this cart: <b><?php echo $this->myCheckout->format_value($this->myCheckout->show_total_value()); ?></b></p>
	<?php /*<p>Total value Tax: <b><?php echo $myCheckout->format_value($myCheckout->create_total_VAT()); ?></b></p> */ ?>
	<p>Shipping value: <b><?php echo $this->myCheckout->format_value($this->myCheckout->show_total_shipping()); ?></b></p>
		<?php
			if (isset($_SESSION['discount']))
				{
				?>
					<p>Discount value: <b><?php echo $this->myCheckout->format_value($_SESSION['discount']); ?></b></p>
					<br>
			<?php } ?>
			
	</td>
	<td align="left" colspan="3" >
	<?php
			if (!empty($this->student->student_name))
				{ 
				  	echo  "<font  style=\"padding-left:0px\"  color=\"#FF0000\">"."Afiliate:"."</font>";
					echo "<br><font  style=\"padding-left:35px\" >".$this->student->student_name."</font>". "<br>";
					echo "<font  style=\"padding-left:35px\" >".$this->student->school_name."</font>". "<br>";
					echo "<font  style=\"padding-left:35px\" >".$this->student->school_city."</font>". "<br>";
								
				}
			?>
					
   </td>
   </tr>
</table>
<?php
		}	
		
function process_pars()
		{
		// cancel the order (with all rows and information) // this function be at the TOP ! 
	if (isset($_GET['action']) && $_GET['action'] == "cancel") {
		$this->myCheckout->cancel_order();
	}
	

// update a single order row
	
	//print "Eppsss...";	
	
	if (isset($_POST['add']) && $_POST['add'] == "Update") { 
		
			$this->myCheckout->update_row($_POST['row_id'], $_POST['quantity']);
		}

// update shipment and process or go back to products
	if (isset($_POST['submit'])) {
		
		if ($_POST['submit'] == "Order now!") 
			$this->myCheckout->check_out($cust_email);	 // place here the mail from your customer or a variable
	
		}

	if (isset($_POST['discount']) && isset($_POST['discount']) == "Apply")
		{
		if ($_POST['number'] == '1193')
			$_SESSION['discount'] = 5.00;
		else
			unset($_SESSION['discount']);
		} 

	if (isset($_POST['student']) && isset($_POST['student']) == "Update")
		{
		$this->student->get_student($_SESSION['order_id']);	
		$this->student->update_student($_POST['name'], $_POST['school'], $_POST['city'], $_SESSION['order_id']);
		}	
	
		
	if (isset($_POST['chgship']) && isset($_POST['chgship']) == "Apply")
		{
			if ($this->frobj->validate('db_cart_magazine'))
				$this->magazine->update_magazine_by_order('', $_SESSION['order_id'], $_SESSION['product_id'],
										 	'OG6',  
										  	'GIFTC',
										  	'ORD',
										  	$_POST['fullname'],  		//$SUSCRIBERNAME,
										  	$_POST['address'], 			//$PRIMARYADDRESS,
										  	$_POST['address2'], 		//$SECONDARYADDRESS,
										  	'', 						//$FOREIGNADDRESS,
										  	$_POST['city'], 			//$CITY,
										  	substr($_POST['state'],0,2), 			//$STATE,
										  	$_POST['zipcode'],			//$ZIPCODE,
										  	'',						//$COUNTRYCODE, 
											'', 					//$EMAILADDRESS,
										  	'', 				//$LISTKEY,
										  	'06711', 				//$BATCHNUMBER, (Fixed)
										  	'10022006',				//$CAGEDATE, 
										  	'',						//$VAR_PART_INFO, 
										  	'',						//$CREDITCARDTYPE,
											'', 					//$PRIVATELABELCARD,
										  	'',						//$CREDITCARDEXPIRE,
										  	'',						//$CREDITCARDNUMBER,
										  	$_POST['product_id'], 				//$OFFERCODE1,
										  	'', 					//$Field21,
										  	'09252006',				//$PARTNERSORDERDT,
										  	$_POST['phone'],		//$HOMETELEPHONE,
											'',						//$ALTERNATETELEPHONE, 
										  	'', 					//$Field25, 
										  	'A',					//$COUNTRYCODE1, 
										  	'D',					//$COMPANYCODE, 
										  	'4',					//$BUSSINESCODE, 
										  	''						//$Field30
											) ;

		} 
	
		
	}
}
	?> 