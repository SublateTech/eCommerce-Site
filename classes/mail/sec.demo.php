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

require_once('sec.class.inc.php');

#To - Name, To - Email, From - Name, From - Email
$sec = new sec('Alvaro Medina', 'alvaro@sigfund.com', $_SERVER['SERVER_NAME'], $_SERVER['SERVER_ADMIN']);

//$sec->Cc('admin@fluxnetworks.co.uk');
//$sec->Cc('webdesign@fluxnetworks.co.uk');
//$sec->Bcc('mark@fluxnetworks.co.uk');
//$sec->Bcc('mdavidson@fluxnetworks.co.uk');

#add image to be embeded
$img1 = $sec->embed('php-power-white.gif');

#produce message in html format
$message = "This is a <b>Test</b> <i>Email</i> from the simpleEmailClass.<br />\n";
$message .= "With an Embeded Image<br />\n";
$message .= "<center>{$img1}</center>\n";
$message .= "and Some Attachments.\n";

#build the message with the message title and message content
$sec->buildMessage('simpleEmailClass Test Message', $message);

#attach files to email
$sec->attachment('sec.demo.php');
$sec->attachment('sec.class.inc.php');

#build and send the email
if($sec->sendmail()) {
	echo 'Your Email Was Sent';
} else {
	echo 'Your Email Failed to be Sent';
}
?>