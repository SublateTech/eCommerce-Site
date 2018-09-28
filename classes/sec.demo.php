<?php
##################################################################################
#
# File				: sec.demo.inc.php - simpleEmailClass Demo File with examples
#					  of using the varies aspects of this class.
# Class Title		: simpleEmailClass 
# Class Description	: This class is used to produce HTML format emails, with
#					  the ability to attach files and embed images.
# Class Notes		: Please Let Me Know if you have any problems at all with this
#					  Class.
# Copyright			: 2007
# Licence			: http://www.gnu.org/copyleft/gpl.html GNU var License
#
# Author 			: Mark Davidson <design@fluxnetworks.co.uk> 
#					  <http://design.fluxnetworks.co.uk>
# Created Date     	: 27/01/2007
# Last Modified    	: 30/01/2007
#
##################################################################################

require_once('sec_class_inc.php');

#To - Name, To - Email, From - Name, From - Email
//$sec = new sec('Mark Davidson', 'alvaro@sigfund.com', $_SERVER['SERVER_NAME'], $_SERVER['SERVER_ADMIN']);

$sec = new sec('Alvaro Medina', 'alvaro@sigfund.com', "Alvaro Medina", "alvaro@sigfund.com");

//$sec->Cc('admin@fluxnetworks.co.uk');
//$sec->Cc('webdesign@fluxnetworks.co.uk');
//$sec->Bcc('mark@fluxnetworks.co.uk');
//$sec->Bcc('mdavidson@fluxnetworks.co.uk');

#add image to be embeded
$img1 = $sec->embed('../images/150H/0113.jpg');


#produce message in html format
$message = "Hello,\n Scott thought that you might be interested in the following item. If you are,<br />\n";
$message .= "please click on the picture<br />"; 
$message .= "<a href='http://www.SignatureFundraising.com'>'<center>{$img1}</center></a\n";
$message .= "<br />\n";
$message .= "We look forward to your visit! <br /><br />\n";
$message .= "Kind Regards,<br /><br />\n";
$message .= "Signature Fundraising, inc. <br />\n"; 
$message .= "<a href='http://www.SignatureFundraising.com'>www.SignatureFundraising.com</a> <br />\n";
$message .= "1-800-649-3863";



#build the message with the message title and message content
$sec->buildMessage('Scott thought that you migth be interested in the following item!', $message);

#attach files to email
//$sec->attachment('sec.demo.php');
//$sec->attachment('sec.class.inc.php');

#build and send the email
if($sec->sendmail()) {
	echo 'Your Email Was Sent';
} else {
	echo 'Your Email Failed to be Sent';
}
?>