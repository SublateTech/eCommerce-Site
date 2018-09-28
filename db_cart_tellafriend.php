<?php
/*$_POST['name'] = "Alvaro";
$_POST['email'] = "Alvaro@SigFund.com";
$_POST['item'] = "0113";
$_POST['fmail1'] = "Alvaro@sigfund.com";
$_POST['fmail2'] = "";
$_POST['fmail3'] = "";*/

if (!session_id()) session_start();

if(count($_POST)) {

$item = $_REQUEST['item'];

require_once('classes/sec_class_inc.php');

#To - Name, To - Email, From - Name, From - Email
//$sec = new sec('Mark Davidson', 'alvaro@sigfund.com', $_SERVER['SERVER_NAME'], $_SERVER['SERVER_ADMIN']);

$sec = new sec('', $_POST[fmail1], $_POST['name'], $_POST['email']);

//$_POST[fmail1],$_POST[fmail2],$_POST[fmail3]
if ($_POST[fmail2] != "")
	$sec->Cc($_POST[fmail2]);
if ($_POST[fmail3] != "")
	$sec->Cc($_POST[fmail3]);

//$sec->Bcc('mark@fluxnetworks.co.uk');
//$sec->Bcc('mdavidson@fluxnetworks.co.uk');

#add image to be embeded
$img1 = $sec->embed('images/150H/'.$item.'.jpg');


#produce message in html format
$message = "Hello,<br> ".$_POST[name]." thought that you might be interested in the following item.<br>" ;
$message .= "If you are please click on the picture. <br />"; 
$message .= "<a href='hhttp://www.SignatureFundraising.com/db_cart_main.php><center>{$img1}</center></a>"; 
//$message .= "<a href=\"hhttp://www.SignatureFundraising.com/db_cart_main.php?view=2&item=".$item."\"><center>{$img1}</center></a>";
$message .= "<br />";
$message .= "We look forward to your visit! <br /><br />";
$message .= "Kind Regards,<br /><br />";
$message .= "Signature Fundraising, Inc. <br />"; 
$message .= "<a href='hhttp://www.SignatureFundraising.com/db_cart_main.php>www.SignatureFundraising.com</a><br />";
$message .= "1-800-645-3863";

//print $message;

#build the message with the message title and message content
$sec->buildMessage($_POST['name'].' thought that you migth be interested in the following item!', $message);

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
?>