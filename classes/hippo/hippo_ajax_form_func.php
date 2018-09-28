<?php
  /* put your global functions here */
  /*
  function escape_string($strSource)
  {
    $aryPatterns = array('/\s+/', '/"+/', '/%+/');
    return preg_replace($aryPatterns, '', $strSource);
  }
  
  function unicode2big5($strSource)
  {
    return iconv('utf-8', 'big5', $strSource);
  }
  
  function big52unicode($strSource)
  {
    return iconv('big5', 'utf-8', $strSource);
  }
  
  function GetClinetBrowser()
  {
    $Agent= $_SERVER["HTTP_USER_AGENT"];
    $browser[0] = 60;
    $browser[1] = 'unknow';
  
    if(strpos($Agent, "Mozilla")){ $browser[0] = 1;$browser[1] = 'unknow';}
    if(strpos($Agent, "Mozilla/4")){ $browser[0] = 1;$browser[1] = '4.0';}
    if(strpos($Agent, "Firebird")){ $browser[0] = 1;$browser[1] = 'Firebird';}
    if(strpos($Agent, "Netscape")){ $browser[0] = 2;$browser[1] = 'unknow';}
    if(strpos($Agent, "Netscape6/")){ $browser[0] = 2;$browser[1] = '6.0';}
    if(strpos($Agent, "Netscape/7.1")){ $browser[0] = 2;$browser[1] = '7.1';}
    if(strpos($Agent, "Opera")){ $browser[0] = 3;$browser[1] = 'unknow';}
    if(strpos($Agent, "Firefox")){ $browser[0] = 4;$browser[1] = 'unknow';}
    if(strpos($Agent, "MSIE")){ $browser[0] = 5;$browser[1] = 'unknow';}
    if(strpos($Agent, "MSIE 6.0")){ $browser[0] = 5;$browser[1] = '6.0';}
    if(strpos($Agent, "MSIE 5.5")){ $browser[0] = 5;$browser[1] = '5.5';}
    if(strpos($Agent, "MSIE 5.0")){ $browser[0] = 5;$browser[1] = '5.0';}
    if(strpos($Agent, "MSIE 4.0")){ $browser[0] = 5;$browser[1] = '4.0';}
    Return $browser;
  }
  */
?>
