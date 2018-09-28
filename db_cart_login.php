<?php 

if($_SERVER['HTTPS'] != "on")
	{header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);exit;}
	
/*if ($_SERVER["SERVER_PORT"] != 443)
{
   header('Location: https://www.x.x');
}*/
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

$_login = new db_cart_login();
	

class db_cart_login
	{	

	var $my_access;
	var $myLogin;
	
	var $login;
	var $password;
	var $checked;
	
	var $page_box;
	
		
function db_cart_login()
		{
		require_once("classes/SiteCookieClass.php");
		require_once("classes/access_user_class.php"); 
		require_once("db_cart_class.php");
		require_once("db_cart_init.php");
		require_once("page.php");
		require_once("db_cart_box.php");
	if (!isset($_SESSION['cust_id'])) 
	{
		SiteCookie::extract("signature");
		if (isset($_COOKIE['cust_id']) && $_COOKIE['cust_id'] >0 )
			{
			
			$_SESSION['cust_id'] = $_COOKIE['cust_id'];
			}
		else
			{
			
			$_SESSION['cust_id'] = 0; //Find a Customer
			
			}
	}
	else
	{

		if ($_SESSION['cust_id'] > 0)
			{
			// Create a local object
			$SiteCookie=new SiteCookie("signature");
		    // Clear all values
			$SiteCookie->clear();

    		// Set the cookie
			$SiteCookie->set();

			$SiteCookie->put("cust_id",$_SESSION['cust_id']);
    		// Set the cookie
			$SiteCookie->set();
			}else
			{
				
				$_SESSION['cust_id'] = 0; //Find a Customer
				
			}
	 }
		
		$this->page_box = new boxstd();
		
		$this->my_access = new Access_user;
		$this->my_access->login_reader();
		
		$cust_no = $_SESSION['cust_id'];
		$this->myLogin = new db_cart($cust_no);
		$this->myLogin->set_customer_data();
		
		
		$this->check_pars();
		
		//echo $_SESSION['cust_id'];
		$this->display();
	}
		
		
	function display()
		{
		$page_htm = new page();
		$page_cnt = new Content();
		


		$page_htm->ShowHeader(); 
		$page_cnt->menu = false;
	  	$page_cnt->Header(); 
		$page_cnt->Header_Center(); 
		
		//$this->show_login();
			$this->show_general();

		 $page_cnt->Footer_Center(); 
		 $page_cnt->Footer(); 
	     $page_htm->EndPage();  ?>
	<?php
		}		
		
		
	function show_general()
		{
			
			if (isset($_SESSION['user']))
				{
				$this->show_general_info();
			}else
				$this->show_login();
		}
	
	function show_general_info()
		{
			$this->page_box->Header();
			?>
					
			<table   width="100%"  align="center" border="0">	
				<tr>
    			 <td colspan="2" align="left">
					  	<img style="margin-top:35px;" src="images/REGISTERED-CUSTOMERS.jpg">
				  </td>
  				</tr>		

				<tr valign="top" >
					<td  width="50%">
						<?php $this->show_orders_short(); 
						
						
						?>
					</td>
					<td >
						<?php $this->show_billing_info(); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php $this->show_options(); ?>
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<?php
						if (isset($_POST['row_id']) && $_POST['row_id'] != '')
							{	$this->show_detail();
							}
					?>
					</td	>
				
				</tr>
				
			<?php $this->footer(1); ?>
			</table>
			<?php
			
			$this->page_box->Footer();
		}
	function show_login()
		{
			?>
		<table   width="100%"  align="center" border="0">	
		<?php 
		if (!$this->myLogin->get_number_of_records() == 0) {
		?>
		<tr> 
			<td align="center" colspan="4"> 	

				<img style="margin-top:35px;" src="images/header_1.jpg" USEMAP = #imagemap />
				<MAP NAME="imagemap">
					<AREA SHAPE="rect" COORDS = "30, 25, 185, 80" HREF="db_cart_login.php"/>
					<AREA SHAPE="rect" COORDS = "190, 25, 345, 80" 	HREF="db_cart_checkout_shipping.php"/>
					<AREA SHAPE="rect" COORDS = "350, 25, 500, 80"  HREF="db_cart_checkout_credit_card.php"/>
				</MAP>

			</td>
		</tr>
	
		<?php } ?>
		<tr>
			<td colspan="4">
			 <div id="error">
			 		<?php
					echo $this->myLogin->error; 
					echo $this->my_access->the_msg; 
					//echo $_SESSION['cust_id'];
					?>
			 </div>
			</td>
		</tr>
		<tr>
			<td colspan="4">
	  			<div id='center_title'>
	 				<font size="+1">  LOGIN </font>
	 				<?php //<hr  style="margin-left:10;" align="left" width="90%" size="1" noshade> ?>
				</div>
			</td>
		</tr>	
		<tr>
			<?php if (!isset($_SESSION['user'])) { ?>	
						<td   class="db_border"  width="50%" align="center" colspan="3">
			 					<?php $this->register_option(); ?>
						</td>
				<?php } ?>
			
						<td  colspan="<?php echo isset($_SESSION['user'])?"4":"1"; ?>" class="db_border" align="center" width="50%">
							<?php  if (!isset($_SESSION['user']))
										$this->login_option(); 
									else
										$this->show_orders_short(); 	
										
										?>
			
  						</td>
		</tr>

		<tr>
			 <?php $this->footer(); ?>
		</tr>
	</table>
	<?php 
		}	
		
	function footer($span=3)
		{?>
						<td >
					<tr>
						<td  valign="bottom">
							<p><a href="./<?php echo PROD_IDX."?cust_id=".$_SESSION['cust_id']; ?>"> <img src="images/CONTINUE-SHOPPING.jpg" /> </a></p>
						</td>
						<?php 
						if (!$this->myLogin->get_number_of_records() == 0)
							{
								if (isset($_SESSION['user']) ) { ?>
						<td   colspan="<?php echo $span ?>" valign="bottom"  align="right">
							
								<p><a href="./<?php echo SHIPPING; ?>"> <img  src="images/CHECKOUT.jpg" /> </a></p>
							
						</td>
						<?php }
							} ?>
					 </tr>	
				</td>

		<?php
		}
	
	function check_pars()
		{
		if (!isset($_SESSION['cust_id']))
			exit;
		
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'log_out')
			{
			$this->my_access->log_out();
			header("Location: ".LOGIN);
			exit;	
			}

		if (isset($_GET['activate']) && isset($_GET['ident'])) { // this two variables are required for activating/updating the account/password
			//$my_access->auto_activation = false; // use this (true/false) to stop the automatic activation
			$this->my_access->activate_account($_GET['activate'], $_GET['ident']); // the activation method 
			//$_SESSION['cust_id'] = 0;
			//header("Location: db_cart_checkout_register.php");
			//exit;	
			}
			
		if (isset($_GET['validate']) && isset($_GET['id'])) { // this two variables are required for activating/updating the new e-mail address
			$this->my_access->validate_email($_GET['validate'], $_GET['id']); // the validation method 
			}
		
		
		if (isset($_POST['submit'])) {
			$this->my_access->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; // use a cookie to remember the login
			$this->my_access->count_visit = true; // if this is true then the last visitdate is saved in the database
			if (!isset($_SESSION['user']))
				{
				$this->my_access->login_user($_POST['login'], $_POST['password']); // call the login method
				$error = $this->my_access->the_msg; 
				
				$this->login    = (isset($_POST['login'])) ? $_POST['login'] : $this->my_access->user;
				$this->password = (isset($_POST['password'])) ? $_POST['password'] : $this->my_access->user_pw;
				$this->checked = ($this->my_access->is_cookie == true) ? " checked" : "";
				//echo $_SESSION['cust_id'];
				//echo $_SESSION['order_id'];
				//echo $_SESSION['user'];
				if (isset($_SESSION['user']))
				{
				  $cust_no = $_SESSION['cust_id'];
				  if ($this->myLogin->cust_user != $_SESSION['user']) 
				  {
					if ($this->myLogin->find_customer_by_user($_SESSION['user']))
						{
						//echo "Encontrado";
						$this->myLogin->swicth_order_cust($_SESSION['cust_id']);
						if (strlen($this->myLogin->cust_user) == 0)
								$this->myLogin->delete_customer($cust_no);	
						$this->myLogin->set_customer_data();			
						}
					//else {
					//	echo "No Encontrado";
					//	$this->myLogin->set_customer_data();
					//	$this->myLogin->cust_user = $_SESSION['user'];
					//	$this->myLogin->cust_email = $this->my_access->user_email;
					//	$this->myLogin->update_customer_from_vars();			
					//	}
				  }
				$this->my_access->get_user_info();
				$this->myLogin->set_customer_data();
				$this->myLogin->cust_user = $_SESSION['user'];
				$this->myLogin->cust_email = $this->my_access->user_email;
				$this->myLogin->cust_firstname = $this->my_access->user_first_name;
				$this->myLogin->cust_lastname = $this->my_access->user_last_name;
				$this->myLogin->update_customer_from_vars();		
				
				}
			}
				//echo $_SESSION['cust_id'];
				//echo $_SESSION['order_id'];
				//echo $_SESSION['user'];

			
			}	
				



			if (isset($_GET['action']) && $_GET['action'] == "RegisterNow") 
				{
			//echo REGISTER;
			//header("Location: ".REGISTER); // change the file name if you need
				if (isset($_SESSION['user'])) {
			
					header("Location: ".SHIPPING); // change the file name if you need
					exit; 
					} else {
					header("Location: db_user_register.php");
					//$myLogin->error = "Please log in and/or register first!!";
					exit; 
					}
				} 
	
		if (isset($_GET['action']) && $_GET['action'] == "CheckoutNow") 
			{
					
				if ($this->myLogin->get_number_of_records() > 0)
					{
						//$this->myLogin->error = "No items in your cart for checking out.";
						header("Location: ".SHIPPING); // change the file name if you need
						exit; 
					}
			} 
		
		}
	
	function register_option()
		{
			$this->page_box->Header(); ?>
			
				<table  border="0"  align="center" cellpadding="0" cellspacing="0">
					<tr>
					  	<td  align="center" valign="bottom" align="center">
					  		<img  style="margin-top:35px;" src="images/new-customers.jpg">
					  	</td>
					</tr>
					
					<tr>
						<td height="100" align="left">
							<img  style="margin-left:10;" src="images/GO.jpg">
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=CheckoutNow"><img src="images/REGISTER-NEXT-TIME.jpg"></a>
						 </td>
					  	<tr>
						<td height="100" align="left">
						<img  style="margin-left:10;" src="images/GO.jpg">
						
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=RegisterNow">
							<img src="images/REGISTER-NOW.jpg">
							</a> <br>
													
					  	</td>
					</tr>

					</tr>
		  		</table>
		  
		 	 <?php $this->page_box->Footer(); 

		}
	
	function login_option()
		{
			$this->page_box->Header(); ?>
			<table   width="50%" align="center"  border="0" cellpadding="0" cellspacing="0">
    				<tr>
    				  <td colspan="3" align="center">
					  	<img style="margin-top:35px;" src="images/REGISTERED-CUSTOMERS.jpg">
						To receive tracking information on your purchase, <br /> please register.
					  </td>
  				  	</tr>
    				<tr>
						<td>
							<tr >
								<td width="30px">
								</td>
								<td  style="padding-top:55px; margin-left:40px;"  align="left" colspan="3" width="80%">
									<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								    	<label class='label_short' for="login">Login:</label>
  										<input type="text" name="login" size="20" value="<?php echo $this->login;  ?>"><br>
								    	<label class='label_short' style="margin-top:10px; "for="password">Password:</label>
								    	<input  style="margin-top:10px; " type="password" name="password" size="20" value="<?php echo $this->password; ?>"><br>
									 	<label class='label_short' for="remember">Remember login?</label>
									 	<input type="checkbox" name="remember" value="yes"<?php echo $this->checked; ?>>
									  	<label class='label_short' for="submit"></label>
									 	<input  style="align:right;" type="submit" name="submit" value="Login" >
									 </form>
								   						   
								  </td>
                             </tr> 
							 
							 
							 <tr >
							 	<td height="35px">
								</td>
								<td  valign="middle" align="left" >
									<a href="db_user_forgot_password.php">
										<img  src="images/icon.jpg">
									</a>	
								</td>
								<td  valign="middle" align="left">
									   <a href="db_user_forgot_password.php">forgot your  password </a>
								</td>
								
							 </tr>
							  
							  <?php if (isset($_SESSION['user'])) { ?>
							  <tr>
							 	<td   valign = "center" height="40px" align="right" >
									<img style="margin-top:35px;" 	 src="images/icon.jpg">
								</td>
								<td align="left">
									<a href="db_cart_checkout_shipping.php">change your account information? </a>
								</td>
								
							 </tr>
							 <tr>
							 	<td   valign="bottom" align="right" >
									<img style="margin-top:35px;"  src="images/icon.jpg">
								</td>
								<td align="left">
									<a href="db_cart_login.php?action=log_out">log out </a>
								</td>
								
							 </tr>
							 <?php } ?>

					  		</td>	
				  </tr>
				
	  	  </table>
		  <?php $this->page_box->Footer(); 

		}
		
	function show_detail()
		{
			  if (isset($_POST['row_id']) && $_POST['row_id'] != '')
										{
																			?>
					<table width="100%">
						<tr><td height='40'></td></tr>
						<tr>
  							<td  bgcolor="#BBBBBB" align="left" >
    								<th bgcolor="#BBBBBB"  height="25"   align="left">Art. no.</th>
    								<th bgcolor="#BBBBBB"   align="left">Product</th>
									<th  bgcolor="#BBBBBB"  align="right">Quantity</th>
									<th  bgcolor="#BBBBBB"  align="right">Price</th>
									<th  bgcolor="#BBBBBB"  align="right">Amount</th>
  							</td>
  						</tr>
						<tr>
							<td>
								<?php
										//echo $_POST['row_id'];
										$this->myLogin->show_ordered_rows($_POST['row_id']);
										foreach ($this->myLogin->order_array as $val) { ?>
								  		<tr>
							    			<td colspan="2"align="center"><?php echo $val['product_id']; ?></td>
											<td align="left"><?php echo $val['product_name']; ?></td>
											<td align="right"><?php echo $val['quantity']; ?></td>
											<td align="right"><?php echo $this->myLogin->format_value($val['price']); ?></td>
											<td align="right"><?php echo $this->myLogin->format_value($val['price'] * $val['quantity']); ?></td>
										</tr>  	<?php } // end foreach loop ?>
										
							
							</td>
						</tr>
						<tr><td height='40'></td></tr>
						</table>
					<?php
					}
		}
		
	function show_orders_short()
		{ 
			$this->myLogin->get_customer_orders();
		?>
			
			
			<table  style="margin-top:10px; " align="center" border="0"  cellspacing="0" cellpadding="0" width="90%">
			<tr>
			    <th>Order</th>
			    <th align="left">Date - Time</th>
			  </tr>
 				 <?php  
  					$i=0;
					foreach ($this->myLogin->orders_array as $val) { ?>
						 <tr>
					    <?php echo "<td align='CENTER' bgcolor=".row_color($i).">";?> <?php echo $val['id']; ?></td>
						<?php echo "<td bgcolor=".row_color($i).">";?> <?php echo $val['order_date']; ?></td>
						<?php echo "<td  bgcolor='ffffff' valign='bottom'   align='center'  bgcolor=".row_color($i).">";?>
						  
						  <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						    <input type="hidden" name="row_id" value="<?php echo $val['id']; ?>">
						    <input type="submit" name="view" value="Detail">
					      </form>  
							</td>
  						</tr>

						
					<?php
						
										?>
  				<?php
  						$i++;
					   }
					   if ($i==0)
					   		echo "<tr><td style='margin-top:10px;' >Currently, there is not orders in your account.</td></tr>";
					    // end foreach loop ?>
				</table>
	<?php
		
		}
	
	function show_orders()
		{
		$this->myLogin->get_customer_orders();
		$this->page_box->Header();
		?>
		<table  style="margin-bottom:40px;" align="center" border="0"  cellspacing="0" cellpadding="0" width="90%">
			<tr>
			    <th>Order</th>
			    <th align="left">Date - Time</th>
				<th align="left">Subtotal</th>
				<th align="left">Discount</th>
				<th align="left">Shipping</th>
				<th align="left">Total</th>
				
			 </tr>
 				 <?php  
  					$i=0;
					foreach ($this->myLogin->orders_array as $val) { ?>
						 <tr>
					    <?php echo "<td align='CENTER' bgcolor=".row_color($i).">";?> <?php echo $val['id']; ?></td>
						<?php echo "<td bgcolor=".row_color($i).">";?> <?php echo $val['order_date']; ?></td>
						<?php echo "<td align='left' bgcolor=".row_color($i).">";?><?php echo $this->myLogin->format_value($val['subtotal']); ?></td>
						<?php echo "<td align='left' bgcolor=".row_color($i).">";?><?php echo $this->myLogin->format_value($val['discount']); ?></td>
						<?php echo "<td align='left' bgcolor=".row_color($i).">";?><?php echo $this->myLogin->format_value($val['shipping']); ?></td>
						<?php echo "<td align='left' bgcolor=".row_color($i).">";?><?php echo $this->myLogin->format_value($val['total']); ?></td>
						<?php echo "<td  bgcolor='ffffff' valign='bottom'   align='center'  bgcolor=".row_color($i).">";?>
						  
						  <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
						    <input type="hidden" name="row_id" value="<?php echo $val['id']; ?>">
						    <input type="submit" name="view" value="Detail">
					      </form>  
								</td>
  						</tr>

						
					<?php
						
										?>
  				<?php
  						$i++;
					   } // end foreach loop ?>
				</table>
				<?php 
			
		}	
	
	function show_billing_info()
		{
		?>
		<table  border="0" style="margin-right:10px; margin-left:10px; margin-top:10px; margin-bottom:40px;" width="90%">
		 <tr valign="top">
		 	<th colspan="2" align="left">Account Information</th>
		 </tr>
		 
		 <tr>
			
			<td colspan="1">
			<?php 
			$this->myLogin->set_customer_data();
			echo "<tr><td>";
			echo "<p class='label_short'>First Name : </p>";
			echo "</td><td width='50%'>";
			echo "<p class='general'>". $this->myLogin->cust_firstname."</p>";
			echo "</td></tr>";
			
			echo "<tr><td>";
			echo "<p class='label_short'>Last Name : </p>";
			echo "</td><td>";
			echo "<p class='general'>".$this->myLogin->cust_lastname."</p>";
			echo "</td></tr>";
			
			echo "<tr><td>";
			echo "<p class='label_short'>Billing Information : </p>";
			echo "</td><td>";
			echo "<p class='general'>".$this->myLogin->cust_address."</p>";
			echo "</td></tr>";
			
			echo "<tr><td>";
			echo "<p class='label_short'>Billing Information 2 : </p>";
			echo "</td><td>";
			echo "<p class='general'>".$this->myLogin->cust_address2."</p>";
			echo "</td></tr>";
			
			echo "<tr><td>";
			echo "<p class='label_short'>City : </p>";
			echo "</td><td>";
			echo "<p class='general'>".$this->myLogin->cust_city." ".$this->myLogin->cust_zipcode."</p>";
			echo "</td></tr>";
			
			echo "<tr><td>";
			echo "<p class='label_short'>State : </p>";
			echo "</td><td>";
			echo "<p class='general'>".$this->myLogin->cust_state."</p>";
			echo "</td></tr>";
			?>

			</td>
		 </tr>
		</table>	
		<?php
		}
	
	
	
	
	function show_options()
	{
	?>
		<table  style="margin-top:40px; margin-bottom:40px;" width="100%">
							  <tr>
							 	<td   valign="bottom" height="20" align="right" >
									<img  style="padding-bottom:0; margin-bottom:0;   " src="images/icon.jpg">
								</td>
								<td   height="20" width="30" align="right">
								
								</td>
								<td align="left">
									<a href="db_user_update.php">change your email or password? </a>
								</td>
								
							 </tr>
							  <?php //if (isset($_SESSION['user'])) { ?>
							  <tr>
							 	<td   valign="bottom" height="20" align="right" >
									<img  style="padding-bottom:0; margin-bottom:0;   " src="images/icon.jpg">
								</td>
								<td   height="20" width="30" align="right">
								
								</td>
								<td align="left">
									<a href="db_cart_checkout_shipping.php">change your account information? </a>
								</td>
								
							 </tr>
							 <tr>
							 	<td   valign="bottom" height="20" align="right" >
									<img  style="padding-bottom:0; margin-bottom:0;   " src="images/icon.jpg">
								</td>
								<td   height="20" width="30" align="right">
								
								</td>
								<td align="left">
									<a href="db_cart_login.php?action=log_out">log out </a>
								</td>
								
							 </tr>
				</table>
	<?php
		//}
	}
	}
	
	function row_color($i)
		{ 
    $bg1 = "#EEEEEE"; // color one     
    $bg2 = "#DDDDDD"; // color two 

    if ( $i%2 )  
        return $bg1; 
     else  
        return $bg2; 
    		
	} 
?>