<?php 
//Example:
require ("_class_processcard.php");
$bibEC_ccp = new bibEC_processCard('authorize_net');
$file = "transaction.log";
$bibEC_ccp->save_log($file);	// the name of a LOG FILE
$cc_user 		= "4336QdFuwLR";
$cc_password 	= "";
$cc_key 		= "8r9E9v7HEDc3S22J";
$admin_email = "shopping@sigfund.com";
$bibEC_ccp->set_user($cc_user, $cc_password, $cc_key, $admin_email);

$fname 		= 'russ';
$lname 		= 'rice';
$address 	= '42850 Signature Court'; 
$city 		= 'Lancaster';
$state 		= "CA";
$zip 		= '93535';
$country 	= "United States";
$phone		= "";
$fax		= "";
$email		= 'alvaro@sigfund.com';


$bibEC_ccp->set_customer($fname, $lname, $address, $city, $state, $zip, $country, $phone, $fax, $email);//can be passed the IP as last field, optional
$bibEC_ccp->set_ship_to($fname, $lname, $address, $city, $state, $zip, $country, $phone, $fax);

$name_on_card 	= "russ rice"; 
$type			= "V";
$number			= "4336948565010144";
$expmm			= "07";
$expyy			= "07";
$cvv			= "782"; //782

$bibEC_ccp->set_ccard($name_on_card, $type, $number, $expmm, $expyy, $cvv);
$bibEC_ccp->set_valuta('USD', '$');

$total_cart		= "1.00";
$order_number	= "101";
$description	= "Signature Fundraising Shopping Cart";

$bibEC_ccp->set_order($total_cart, $order_number, $description, 'auth_capture', NULL, NULL, NULL);	//the last 5 fields are:
																							//	mode
																							//	authcode
																							//	transnum
																							//  currency code
																							//  currency simbol

//I am going to set extra fields if the gateway needs them

//$extra['ipaddress']	= $_SERVER['REMOTE_ADDR'];	//not necessary anymore from version 1.2.4
$extra['app-level']		= 0;		// ONLY FOR PLUG_N_PAY
									// 0 Anything Goes. No transaction is rejected based on AVS 
									// 1 Requires a match of Zip Code or Street Address, but will allow cards where the address information is not available. (Only 'N' responses will be voided) 
									// 2 Reserved For Special Requests 
									// 3 Requires match of Zip Code or Street Address. All other transactions voided; including those where the address information is not available. 
									// 4 Requires match of Street Address or a exact match (Zip Code and Street Address). All other transactions voided; including those where the address information is not available. 
									// 5 Requires exact match of Zip Code and Street Address.  All other transactions voided; including those where the address information is not available. 
									// 6 Requires exact match of Zip Code and Street Address, but will allows cards where the address information is not available. 
$bibEC_ccp->set_extra($extra);	//I need to pass an array

if(!$bibEC_ccp->process()){
	//print_r($bibEC_ccp->get_error());
	print $bibEC_ccp->error['text'];
	echo "<br>";
} else {
	//save the order!!!!
	//printing the authorization code
	echo $bibEC_ccp->get_authorization();
	echo 'HERE I HAVE TO SAVE THE CART, SEND EMAILS AROUND, DELETE CREDIT CARD INFO';
}
//if I want, I can print what I retrieve from the gateway

print_r($bibEC_ccp->get_answer());
echo "<br>";
print_r($bibEC_ccp->get_log());
echo "<br>";
//if I have a file with the LOG I can retrieve all the log with this :
print_r($bibEC_ccp->get_log_all());
//echo "<br>";
?>