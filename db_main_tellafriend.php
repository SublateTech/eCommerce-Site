<?php

if (!session_id()) session_start();

if(count($_POST)) {


require_once('classes/sec_class_inc.php');

#To - Name, To - Email, From - Name, From - Email
//$sec = new sec('Mark Davidson', 'alvaro@sigfund.com', $_SERVER['SERVER_NAME'], $_SERVER['SERVER_ADMIN']);

$sec = new sec('', $_POST['email'], $_POST['name'], $_POST['email']);

//$_POST[fmail1],$_POST[fmail2],$_POST[fmail3]
if ($_POST[fmail1] != "")
	$sec->Bcc($_POST[fmail1]);
if ($_POST[fmail2] != "")
	$sec->Bcc($_POST[fmail2]);
if ($_POST[fmail3] != "")
	$sec->Bcc($_POST[fmail3]);
if ($_POST[fmail4] != "")
	$sec->Bcc($_POST[fmail4]);
if ($_POST[fmail5] != "")
	$sec->Bcc($_POST[fmail5]);
if ($_POST[fmail6] != "")
	$sec->Bcc($_POST[fmail6]);
if ($_POST[fmail7] != "")
	$sec->Bcc($_POST[fmail7]);
if ($_POST[fmail8] != "")
	$sec->Bcc($_POST[fmail8]);
if ($_POST[fmail9] != "")
	$sec->Bcc($_POST[fmail9]);
if ($_POST[fmail10] != "")
	$sec->Bcc($_POST[fmail10]);


//$sec->Bcc('mark@fluxnetworks.co.uk');
//$sec->Bcc('mdavidson@fluxnetworks.co.uk');

#add image to be embeded
//$img1 = $sec->embed('images/150H/'.$item.'.jpg');


#produce message in html format
$message = "Hello,<br>";
$message .= "$_POST[name]'s school is currently having a fundraiser and is asking that you help by visiting  <a href=hthttp://www.SignatureFundraising.com/db_cart_main.php?Home>www.SignatureFundraising.com</a> and shop online.<br><br>";
$message .= "$_POST[SchoolName], $_POST[SchoolCity] $_POST[SchoolState] will receive up to 50% of your sale to benefit their fundraising efforts.<br><br>";
$message .= "To ensure that $_POST[name] and $_POST[SchoolName] receive credit for your purchase, please be sure to include $_POST[name]'s name,<br>";
$message .= "$_POST[name]'s school and the School's city & state in the appropiate boxes during the check out process.<br><br>";
$message .= "We look forward to your visit!<br><br>";
$message .= "Kind Regards,<br><br>";
$message .= "Signature Fundraising Inc.<br>";
$message .= "<a href=hthttp://www.SignatureFundraising.com>www.SignatureFundraising.com</a><br>";
$message .= "1-800-645-3863<br>";


 
//print $message;

#build the message with the message title and message content
$sec->buildMessage("An important message about $_POST[name]'s school fundraiser", $message);

#attach files to email
//$sec->attachment('sec.demo.php');
//$sec->attachment('sec.class.inc.php');

#build and send the email
if($sec->sendmail()) {
	//echo 'Your Email Was Sent';
	# After submission, the thank you page
	$thankyoupage = "db_cart_tell_a_friend.php?close";
	header("Location: $thankyoupage");
exit;

} else {
	echo 'Your Email Failed to be Sent';
}



}






# Nothing further can be changed. Leave the below as is

function is_secure($ar) {
$reg = "/(Content-Type|Bcc|MIME-Version|Content-Transfer-Encoding)/i";
if(!is_array($ar)) { return preg_match($reg,$ar);}
$incoming = array_values_recursive($ar);
foreach($incoming as $k=>$v) if(preg_match($reg,$v)) return false;
return true;
}

function array_values_recursive($array) {
$arrayValues = array();
foreach ($array as $key=>$value) {
if (is_scalar($value) || is_resource($value)) {
$arrayValues[] = $value;
$arrayValues[] = $key;
}
elseif (is_array($value)) {
$arrayValues[] = $key;
$arrayValues = array_merge($arrayValues, array_values_recursive($value));
}
}
return $arrayValues;
}

?>

