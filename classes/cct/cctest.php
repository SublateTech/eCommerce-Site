<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>Credit Card Test Results</title>
</head>
<body>
<?php

include ( "credit_card_verification.inc" );
$cc = new Validate_Credit_Card;

$card_number = trim ( $_POST [ "cc_number" ] );
$expiration_month = trim ( $_POST [ "expiration_month" ] );
$expiration_year = trim ( $_POST [ "expiration_year" ] );

echo ( "<br/><b>Check Credit Card Number by itself...</b>" );
$ret = $cc->is_valid_number ( $card_number );
if ( $ret == CC_SUCCESS )
{

  echo ( "<br/>Valid CC Number ($card_number) for ".$cc->get_credit_card_name() );
  
}else{

  echo ( "<br/>".$cc->get_error_text ( $ret ). " for number $card_number" );
  
}


echo ( "<br/><br/><b>Check Expiration Date by itself...</b>" );
$ret = $cc->is_valid_expiration ( $expiration_month, $expiration_year );
if ( $ret == CC_SUCCESS )
{
  echo ( "<br/>Valid Expiration Date $expiration_month\\$expiration_year" );
}else{
  echo ( "<br/>".$cc->get_error_text ( $ret )." for date $expiration_month\\$expiration_year" );
}


echo ( "<br/><br/><b>Check Both with one function call...</b>" );
$ret = $cc->is_valid_card ( $card_number, $expiration_month, $expiration_year );
if ( $ret == CC_SUCCESS )
{
  echo ( "<br/>Valid Credit Card $card_number Month: $expiration_month Year: $expiration_year" );
}else{
  echo ( "<br/>".$cc->get_error_text ( $ret ) );
}

?>
</body>
</html>
