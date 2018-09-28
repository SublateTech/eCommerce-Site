<?php
  /* put your global functions here */
  
  function escape_string($strSource)
  {
    //$aryPatterns = array('/\s+/', '/"+/', '/%+/');
	$aryPatterns = array('/"+/', '/%+/');
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
  
  function GetBrowser()
  {
    $Agent= $_SERVER["HTTP_USER_AGENT"];
    $browser[0] = 60;
    $browser[1] = 'unknow';
  
//    if(substr($Agent,0,5) == "Opera")
//		print $Agent;
  
    if(strpos($Agent, "Mozilla")){ $browser[0] = 1;$browser[1] = 'unknow';}
    if(strpos($Agent, "Mozilla/4")){ $browser[0] = 1;$browser[1] = '4.0';}
    if(strpos($Agent, "Firebird")){ $browser[0] = 1;$browser[1] = 'Firebird';}
    if(strpos($Agent, "Netscape")){ $browser[0] = 2;$browser[1] = 'unknow';}
    if(strpos($Agent, "Netscape6/")){ $browser[0] = 2;$browser[1] = '6.0';}
    if(strpos($Agent, "Netscape/7.1")){ $browser[0] = 2;$browser[1] = '7.1';}
    if(substr($Agent,0,5) == "Opera"){$browser[0] = 3; $browser[1] = 'unknow';}
    if(strpos($Agent, "Firefox")){ $browser[0] = 4;$browser[1] = 'unknow';}
    if(strpos($Agent, "MSIE")){ $browser[0] = 5;$browser[1] = 'unknow';}
    if(strpos($Agent, "MSIE 7.0")){ $browser[0] = 5;$browser[1] = '7.0';}
	if(strpos($Agent, "MSIE 6.0")){ $browser[0] = 5;$browser[1] = '6.0';}
    if(strpos($Agent, "MSIE 5.5")){ $browser[0] = 5;$browser[1] = '5.5';}
    if(strpos($Agent, "MSIE 5.0")){ $browser[0] = 5;$browser[1] = '5.0';}
    if(strpos($Agent, "MSIE 4.0")){ $browser[0] = 5;$browser[1] = '4.0';}
	if(strpos($Agent, "Firefox")){ $browser[0] = 6;$browser[1] = '2.0';}
		
    Return $browser;
  }

	function GetStateById($state)
		{
		
		$state_list = array('AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming");
			
			return $state_list[$state];
		}
  
?>
