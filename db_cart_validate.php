<?php  
  /* Requires */
//  require("db_cart_class.php");
  //require('classes/hippo_ajax_form_class.php');
//$db_validate = new  db_cart_validate($module);
 
  
class db_cart_validate {


	var $error = '';

	function validate($module='none')
		{
	switch ($module)
		{
		case 'checkout_register':
			return $this->validate_checkout_register();
			break;
		case 'checkout_creditcard':
			return $this->validate_checkout_creditcard();
			break;
		case 'shipment':
			return $this->validate_checkout_shipment();
			break;
		case 'db_cart_login':
			return $this->validate_login();
			break;
		case 'db_cart_magazine':
			return $this->validate_magazines();
			break;
		case 'fund_form':
			return $this->validate_fund_form();
			break;

					
	default:
		{
			//echo "module ".$module." not found!!";
		}
		}	
	}
	

	function validate_checkout_creditcard()
		{
		$OK = true;
		 /* Submit Data */
  		if(isset($_POST['submit_form']))
   			{
  
  			$cust_no = $_SESSION['cust_id'];
			$myValidate = new db_cart($cust_no);

  
    		//$_POST = $_POST['aryFormData'];

			if ($_POST['number'] =='')
				{ $this->error .= "Credit Card Number field is required <br>";	$OK = false; }
			if ($_POST['holder'] =='')
				{ $this->error .= "Credit Card Holder is required <br>";	$OK = false; }
			if ($_POST['exp_month'] == 'Default') 
				{ $this->error .= "Credit Card Expiration Month is required <br>";	$OK = false; }
			if ($_POST['exp_year'] == 'Default')
				{ $this->error .= "Credit Card Expiration Year is required  <br>"; $OK = false; }
			elseif ($_POST['exp_year'] <= date('Y') && $_POST['exp_month'] <= date('n') )
					{ echo "Please change exp_year or exp_month"; $OK = false; }
			
			if ($_POST['CVN'] == '')
				{ $this->error .= "Credit Card CVN Number is required <br>"; $OK = false; }
			

			if ($OK)
				{
				//Credit Card Validation
				require_once ( "classes/credit_card_validation_Class.php");
				$cc = new Validate_Credit_Card;
				//$_POST['number'], $_POST['exp_month'], $_POST['exp_year']
				$myValidate->set_customer_creditcard_data();
				$card_number 		= str_replace(" ","",str_replace(")","",str_replace("(","",str_replace(".","",str_replace("-","",$_POST['number']))))); //trim ( $_POST [ "number" ] );
				$expiration_month 	= $_POST['exp_month'];      //trim ( $_POST [ "expiration_month" ] );
				$expiration_year 	= $_POST['exp_year'];        //trim ( $_POST [ "expiration_year" ] );
				$myValidate->error =  "<br/><b>Check Credit Card Number by itself...</b>" ;
				$ret = $cc->is_valid_number ( $card_number );
				
				if ( $ret == CC_SUCCESS )
				{

  					//echo "Valid CC Number ($card_number) for ".$cc->get_credit_card_name()."<br>" ;
  
				}else{

		  			$this->error .= $cc->get_error_text ( $ret ). " for number $card_number"."<br/>" ;
  	
				}


				$myValidate->error =  "<br/><br/><b>Check Expiration Date by itself...</b>" ;
				$ret = $cc->is_valid_expiration ( $expiration_month, $expiration_year );
				if ( $ret == CC_SUCCESS )
					{
		  			//echo "Valid Expiration Date $expiration_month\\$expiration_year<br/>" ;
					}else{
		  			$this->error .=  $cc->get_error_text ( $ret )." for date $expiration_month\\$expiration_year"."<br/>" ;
					}


				//echo  "<b>Check Both with one function call...</b>"."<br/>" ;
				$ret = $cc->is_valid_card ( $card_number, $expiration_month, $expiration_year );
				if ( $ret == CC_SUCCESS )
					{
				 
				  // echo   "<br/>Valid Credit Card $card_number Month: $expiration_month Year: $expiration_year" ;
					 if ($myValidate->update_creditcard($card_number, $expiration_month, $expiration_year, $_POST['holder'],$_POST['CVN'], $cc->get_credit_card_name()))
				  	 	{
					 		$_SESSION['payment'] = "OK";
							return true;
				  		}
			 	 		elseif (isset($_SESSION['payment']))
							{	
							unset($_SESSION['payment']);
							$this->error .=   "<br/>".$cc->get_error_text ( $ret ) ;
			         		}
	 							
						$this->error .= $myValidate->error;
					}	
			 	}
				return false;   	
			
			} // change the file name if you need} 
	
		
		}
		
	function validate_checkout_register()
		{
		
		 /* Submit Data */
  	if(isset($_POST['submit_form']))
   		{
  
  		$OK = true;
		$cust_no = $_SESSION['cust_id'];
		$myCheckout = new db_cart($cust_no);

		
		if ($_POST['firstname'] =='' )
			{ $this->error .= "First Name field required <br>";	$OK = false; }
		if ($_POST['lastname'] =='')
			{ $this->error .= "Last Name field required<br>"; $OK = false; }	
		if ($_POST['address'] == '')
			{ $this->error .= "Address field required <br>";	$OK = false; }
		if ($_POST['city'] == '')
			{ $this->error .= "City field required <br>";	$OK = false; }	
		if ($_POST['zipcode'] == '')
			{ $this->error .= $_POST['zipcode'].'<br>';	 $OK = false; }	
		if ($_POST['state'] == '')
			 { $this->error .= "State field required <br>";	$OK = false; }

		if ($OK)		
			{
			$myCheckout->update_customer($_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['address2'],$_POST['zipcode'], 				$_POST['city'], $_POST['state'], '', '', $_POST['phone'], $_SESSION['user']);
			$this->error .= $myCheckout->error;
			return true;
			}

  }
  	return false;

 		
} /*End Function */

function validate_login()
	{
		if (isset($_SESSION['user']))	
			{
				echo "You are already logged";
			}
	}
	
	
function validate_checkout_shipment()
	{
	 /* Submit Data */
  	
	if(isset($_POST['submit_form']))
   		{
  		$OK = true;
  		$cust_no = $_SESSION['cust_id'];
		$myCheckout = new db_cart($cust_no);

    	//$_POST = $_POST['aryFormData'];

		$this->error = '';
		
		//if (!isset($_SESSION['user']))
		//	{
		
			if ($_POST['b_firstname'] =='' )
				{ $this->error .= "Billing First Name field required <br>";	$OK = false; }
			if ($_POST['b_lastname'] =='')
				{ $this->error .= "Billing Last Name field required<br>"; $OK = false; }	
			if ($_POST['b_address'] == '')
				{ $this->error .= "Billing Address field required <br>";	$OK = false; }
			if ($_POST['b_email'] == '')
				{ $this->error .= "Billing eMail Address field required <br>";	$OK = false; }
			if ($_POST['b_city'] == '')
				{ $this->error .= "Billing City field required <br>";	$OK = false; }	
			if ($_POST['b_zipcode'] == '')
				{ $this->error .= "Billing Zipcode field required <br>";	$OK = false; }
		//	if ($_POST['b_state'] == '' || $_POST['b_state'] == 'Default')
		//	 { $this->error .= "Billing State field required <br>";	$OK = false; }
			 
	//		 if ($OK)
	//		 	{
					$myCheckout->set_customer_data();
					$myCheckout->cust_firstname = $_POST['b_firstname'];
					$myCheckout->cust_lastname = $_POST['b_lastname'];
					$myCheckout->cust_address = $_POST['b_address'];
					$myCheckout->cust_address2 = $_POST['b_address2'];
					$myCheckout->cust_city = $_POST['b_city'];
					$myCheckout->cust_zipcode = $_POST['b_zipcode'];
					$myCheckout->cust_state = $_POST['b_state'];
					$myCheckout->cust_phone = $_POST['b_phone'];
					$myCheckout->cust_email = $_POST['b_email'];
					$myCheckout->update_customer_from_vars();
				
				
				if (isset($_POST['b_ship']) && $_POST['b_ship'] == 'on')
					{
						//echo $_POST['b_ship'];	
						$myCheckout->update_shipment($_POST['b_firstname'], $_POST['b_lastname'], $_POST['b_address'], $_POST['b_address2'],$_POST['b_zipcode'], $_POST['b_city'], $_POST['b_state'], $_POST['b_phone'],$_POST['b_email']);
					
					}
					
				if (isset($_POST['b_ship']) && $_POST['b_ship'] == 'on' && $OK)
					{
						$_SESSION['shipping'] = "OK";
				 		return true;
					}
					
//				} 
		

		if ($_POST['firstname'] =='' )
			{ $this->error .= "Shipping First Name field required <br>";	$OK = false; }
		if ($_POST['lastname'] =='')
			{ $this->error .= "Shipping Last Name field required<br>"; $OK = false; }	
		if ($_POST['address'] == '')
			{ $this->error .= "Shipping Address field required <br>";	$OK = false; }
		if ($_POST['city'] == '')
			{ $this->error .= "Shipping City field required <br>";	$OK = false; }	
		if ($_POST['zipcode'] == '')
			 { $this->error .= "Shipping Zipcode field required <br>";	$OK = false; }
		if ($_POST['phone'] == '')
			 { $this->error .= "Shipping Phone field required <br>";	$OK = false; }
		if ($_POST['state'] == ''  || $_POST['state'] == 'Default')
			 { $this->error .= "Shipping State field required <br>";	$OK = false; }

		if ($OK) 
		
			{
				$myCheckout->update_shipment($_POST['firstname'], $_POST['lastname'], $_POST['address'], $_POST['address2'],$_POST['zipcode'], $_POST['city'], $_POST['state'], $_POST['phone'],'');
				$_SESSION['shipping'] = "OK";
				$this->error .= $myCheckout->error;
				return true;
			}
			elseif (isset($_SESSION['shipping']))
				{	unset($_SESSION['shipping']); }
							
				
		
	  } else  {
  				$this->error ='';		
								
	  } /*End: if(isset($_POST['aryFormData']))*/
 	return false;	
}
// first update eventually modified data

function validate_magazines()
	{
	 /* Submit Data */
  	
	if(isset($_POST['chgship']))
   		{
  		
			$OK = true; 
			$this->error = '';
			if ($_POST['fullname'] =='' )
				{ $this->error .= "Suscriber Full Name field required <br>";	$OK = false; }
			if ($_POST['address'] == '')
				{ $this->error .= "Suscriber Address field required <br>";	$OK = false; }
			if ($_POST['phone'] == '')
				{ $this->error .= "Suscriber Phone field required <br>";	$OK = false; }
			if ($_POST['city'] == '')
				{ $this->error .= "Suscriber City field required <br>";	$OK = false; }	
			if ($_POST['zipcode'] == '')
				{ $this->error .= "Suscriber Zipcode field required <br>";	$OK = false; }
			if ($_POST['state'] == '' || $_POST['state'] == 'Default')
			 { $this->error .= "Suscriber State field required <br>";	$OK = false; }
			 
			 if ($OK)
			 	{
					return true;
				} 
									
	  		} else  
	  		{
  				$this->error ='';		
								
	  		} /*End: if(isset($_POST['aryFormData']))*/
 	return false;	
}
// first update eventually modified data
function validate_fund_form()
	{
	 /* Submit Data */
  	
	if($_POST)
   		{
  		
			$OK = true; 
			$this->error = '';
			if ($_POST['b_email'] =='' )
				{ $this->error .= "eMail field required <br>";	$OK = false; }
			if ($_POST['b_firstname'] == '')
				{ $this->error .= "First Name field required <br>";	$OK = false; }
			if ($_POST['b_lastname'] == '')
				{ $this->error .= "Last Name field required <br>";	$OK = false; }
			if ($_POST['b_fund'] == '' || $_POST['b_fund'] == 'Default')
			 { $this->error .= "Fundraiser field required <br>";	$OK = false; }
			 
			 if ($OK)
			 	{
					return true;
				} 
									
	  		} else  
	  		{
  				$this->error ='';		
								
	  		} /*End: if(isset($_POST['aryFormData']))*/
 	return false;	
}

}
?>
