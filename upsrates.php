<?php
/*
UPS Service Selection Codes
01 - UPS Next Day Air 
02 - UPS Second Day Air 
03 - UPS Ground 
07 - UPS Worldwide Express 
08 - UPS Worldwide Expedited 
11 - UPS Standard 
12 - UPS Three-Day Select 
13 Next Day Air Saver 
14 - UPS Next Day Air Early AM 
54 - UPS Worldwide Express Plus 
59 - UPS Second Day Air AM 
65 - UPS Saver 
*/
require("classes/upsRate.php");
$fromzip ="93535";
$tozip = "93535";
$service = "03";
$length = 5;
$width = 5;
$height = 5;
$weight = 1;
$myRate = new upsRate('DC3CE642312AFD18','amedinag','michelle','9E6417');
echo $myRate->getRate($fromzip,$tozip,$service,$length,$width,$height,$weight);
?>