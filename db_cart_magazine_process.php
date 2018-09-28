<?php 

require_once("db_cart_class.php");
require_once("db_cart_magazines.php");

//send_ftp("Test");	

//die("leaving...");

$magazine = new cart_magazines();

$magazine->get_orders_with_magazines();
$magazine->delete_magazine_file();
$today = getdate();
$strtoday = date("mdy");
$filename = "SF".$today['mon'].$today['mday'].$today['year']."-".$today['hours'].$today['minutes'].$today['seconds'].".txt";
//print $strtoday;
//print sprintf("%09s",80);

//$_POST['number'] = "4460-2477-5087-9803";
//print str_replace(" ","",str_replace(")","",str_replace("(","",str_replace(".","",str_replace("-","",$_POST['number']))))); //trim ( $_POST [ "number" ] );

//unlink($filename);
//insert_error("jlkja");

/*mysql_connect("207.104.236.2", "signatv9_sa", "sa"); 
mysql_select_db("signatv9_signature"); 
echo mysql_error();

$sql_check = sprintf("SELECT Count(*) as num FROM %s WHERE open='n'", ORDERS);
		if ($res_check = mysql_query($sql_check)) {
			echo mysql_result($res_check, 0, "num");
			}

exit();
*/
$count = count($magazine->orders_magazines_array);
$counter = 0;
if ($count>0)
{
	
	$magazine->save_file($filename,"HDR ".$strtoday);
	foreach ($magazine->orders_magazines_array as $val) 
	{
	
	
		//print $val['order_id']."<BR>";
		//print $val['product_id']." ";
		//print $val['product_name']." ";
		//print $val['quantity']."<br>";
		
		$order_id = $val['order_id'];
		
		
		//Getting order detail!
		$magazine->get_magazines_items($order_id);
		foreach ($magazine->magazines_array_items as $val) 
  		{
  			echo $val['order_id']." ";  
			echo $val['Product_id']." ";  
			echo $val['price']." ";  
			echo $val['quantity']." ";  
			echo $val['order_date']." ";  
			echo $val['customer']."<br>";  
	
			$cust_no = $val['customer'];
			$myCheckout = new db_cart($cust_no);

			$myCheckout->set_customer_data();
	
	
			echo $myCheckout->cust_firstname." ";
			echo $myCheckout->cust_lastname." ";
			echo $myCheckout->cust_address." ";
			echo $myCheckout->cust_phone." ";
			echo $myCheckout->cust_city." ";
			echo $myCheckout->cust_state." ";
			echo $myCheckout->cust_zipcode."<br>";
			
			$phone = str_replace(" ","",str_replace(")","",str_replace("(","",str_replace(".","",str_replace("-","",substr($myCheckout->cust_phone,0,10))))));
			$phone = (strlen($phone)<10)?"":substr($phone,0,10);
			
			$magazine->get_magazine_by_order_file($val['order_id'], $val['Product_id']);
			
			$magazine->update_magazine($val['order_id'], $val['Product_id'],
 			'OG6',  
  			'GIFTC',
  			'ORD',
  			strtoupper($myCheckout->cust_firstname." ".$myCheckout->cust_lastname),  		//$SUSCRIBERNAME,
  			strtoupper($myCheckout->cust_address), 				//$PRIMARYADDRESS,
  			'', 					//$SECONDARYADDRESS,
  			'', 					//$FOREIGNADDRESS,
  			strtoupper(substr($myCheckout->cust_city,0,13)), 		//$CITY,
  			strtoupper(substr($myCheckout->cust_state,0,2)), 					//$STATE,
  			substr(str_replace("-","",$myCheckout->cust_zipcode),0,5),				//$ZIPCODE,
  			'',						//$COUNTRYCODE, 
			$myCheckout->cust_email, 	//$EMAILADDRESS,
  			($val['price']==20?"GWF824":"GWF816"), 	//$LISTKEY,
  			'06711', 				//$BATCHNUMBER, 
  			$val['order_date'],		//$CAGEDATE, 
  			'SIGNATURE',			//$VAR_PART_INFO,  
  			'',						//$CREDITCARDTYPE,
  			'', 					//$PRIVATELABELCARD,
  			'',						//$CREDITCARDEXPIRE,
  			'',						//$CREDITCARDNUMBER,
  			$val['Product_id'], 	//$OFFERCODE1,
  			'', 					//$Field21,
  			$strtoday,				//$PARTNERSORDERDT,
  			$phone,					//$HOMETELEPHONE,
  			'',						//$ALTERNATETELEPHONE, 
  			'', 					//$Field25, 
  			'A',					//$COUNTRYCODE1, 
  			'D',					//$COMPANYCODE, 
  			'4',					//$BUSSINESCODE, 
  			''						//$Field30
				) ;

		$magazine->set_magazine_data_by_order($val['order_id'], $val['Product_id']);
			//if ($val['processed']=="1")
			//	$magazine->save_file($filename,"*".$magazine->prepare_text_to_send());
			//else
			//	{
		$magazine->save_file($filename,$magazine->prepare_text_to_send());
		$counter ++;
			//	$magazine->set_flag_off($val['order_id'], $val['Product_id']);
			//	}
		$magazine->update_magazine_data($val['order_id'], $val['Product_id']);
		
	}
	
 }
$magazine->save_file($filename,"TRL ".sprintf("%09s", $counter));
send_ftp($filename);	
} else
	echo "Nothing to do";
exit;
$order_id = 251;

$magazine->get_magazines_items($order_id); //Get rows
foreach ($magazine->magazines_array_items as $val) 
  {
  		echo $val['order_id']."<br>";  
		echo $val['Product_id']."<br>";  
		echo $val['quantity']."<br>";  
		echo $val['customer']."<br>";  
	
		$cust_no = $val['customer'];
		$myCheckout = new db_cart($cust_no);

		$myCheckout->set_customer_data();
	
	
		echo $myCheckout->cust_firstname."<br>";
		echo $myCheckout->cust_lastname."<br>";
		echo $myCheckout->cust_address."<br>";
		echo $myCheckout->cust_phone."<br>";
		echo $myCheckout->cust_city."<br>";
		echo $myCheckout->cust_zipcode."<br>";
		echo $myCheckout->cust_state."<br>";
		echo $myCheckout->cust_zipcode."<br>";
		
		
		/* Creating records if its necessary */
		
		
		$number_rows = $magazine->get_number_of_records($order_id, $val['Product_id']);
		if ($number_rows == $val['quantity'])
			echo "ok...";
		elseif ($number_rows > $val['quantity'])
			echo "Problems!!!"; 
		else
			{
				echo "Create the rest...";
				$rest = $val['quantity'] - $number_rows;
				$i = 0;
				for ($i=1; $i <= $rest; $i++ )
					{
						echo "<br><b>-------New Ones -------------".$i."</b><br>";
						$magazine->add_magazine($order_id, $val['Product_id']);
						
					}

			}
	
		/*
		
		
		$order_id = $val['order_id'];
		$magazine->get_magazines_by_order($order_id);

		$i=0;
		foreach ($magazine->magazines_array as $val) 
			  {
			 	$magazine->set_magazine_data($val['ID']);
				$number_items = $magazine->get_number_of_items($order_id, $val['product_id']);
				
	
		
			echo $val['order_id']."<br>";
			echo $val['product_id']."<br>";
			//echo "<b>Rows:".$number_rows."</b>";
			//echo "<b>Items:".$number_items."</b>";
	
	
			if (empty($val['SUSCRIBERNAME']))
				$magazine->SUSCRIBERNAME 	= 	$myCheckout->cust_firstname." ".$myCheckout->cust_lastname;
	
			if (empty($val['PRIMARYADDRESS']))
				$magazine->PRIMARYADDRESS	=	$myCheckout->cust_address;
		
			if (empty($val['SECONDARYADDRESS']))
				$magazine->SECONDARYADDRESS	=	$myCheckout->cust_address2;
	
			if (empty($val['CITY']))
				$magazine->CITY				=	$myCheckout->cust_city;
	
			if (empty($val['STATE']))
				$magazine->STATE			=	$myCheckout->cust_state;
		
			if (empty($val['ZIPCODE']))
				$magazine->ZIPCODE			=	$myCheckout->cust_zipcode;
		
			if (empty($val['LISTKEY']))
				$magazine->LISTKEY 			=	$val['product_id'];
			
			if (empty($val['OFFERCODE1']))
				$magazine->OFFERCODE1 		=	"GXXXXXX";
		
			if (empty($val['HOMETELEPHONE']))
				$magazine->HOMETELEPHONE=	$myCheckout->cust_phone;
			
			if (empty($val['ALTERNATETELEPHONE']))
				echo '';
			
			if (empty($val['EMAILADDRESS']))
				$magazine->EMAILADDRESS	=	$myCheckout->cust_email;
	
			$magazine->update_magazine_from_vars($val['ID']);
	
  			$i++;
			
		  }

		*/	
	
  }



exit;


/*
$magazine = new cart_magazines(5);
echo $magazine->error;
$magazine->update_magazine(5, '', 'G5050',
 	'OG6',  
  	'GIFTC',
  	'ORD',
  	'ALVARO MEDINA',  		//$SUSCRIBERNAME,
  	'MI CASA', 				//$PRIMARYADDRESS,
  	'OTRA CASA', 			//$SECONDARYADDRESS,
  	'FORIEGN CASA', 		//$FOREIGNADDRESS,
  	'LANCASTER', 			//$CITY,
  	'CA', 					//$STATE,
  	'93535',				//$ZIPCODE,
  	'',						//$COUNTRYCODE, 
	'ALVARO.MEDINA@SUBLATE.COM', 	//$EMAILADDRESS,
  	'G5050', 				//$LISTKEY,
  	'06711', 				//$BATCHNUMBER, 
  	'10022006',				//$CAGEDATE, 
  	'',						//$VAR_PART_INFO, 
  	'',						//$CREDITCARDTYPE,
  	'', 					//$PRIVATELABELCARD,
  	'',						//$CREDITCARDEXPIRE,
  	'',						//$CREDITCARDNUMBER,
  	'G5230', 				//$OFFERCODE1,
  	'', 					//$Field21,
  	'09252006',				//$PARTNERSORDERDT,
  	'6619461674',			//$HOMETELEPHONE,
  	'',						//$ALTERNATETELEPHONE, 
  	'', 					//$Field25, 
  	'A',					//$COUNTRYCODE1, 
  	'D',					//$COMPANYCODE, 
  	'4',					//$BUSSINESCODE, 
  	''						//$Field30
) ;

$magazine->set_magazine_data(5);
$magazine->save_file("hola.txt",$magazine->prepare_text_to_send());

exit;

*/

function send_ftp($filename)
{

include "classes/ftp_class.php";

$ftp = new ftp(FALSE);
$ftp->Verbose = FALSE;
$ftp->LocalEcho = FALSE;
if(!$ftp->SetServer("transit.customersvc.com")) {
	$ftp->quit();
	die("Setiing server failed\n");
}

if (!$ftp->connect()) 
	die("Cannot connect\n");
else
	echo "<br>Connecting to transit.customersrv.com";
	
if (!$ftp->login("sgn", "sgn4ftp")) {
	$ftp->quit();
	die("Login failed\n");}
else
	echo "<br>Logged in..";

if ($ftp->chdir("in"))
	echo "<br>CD In Ok...";
	
if(FALSE !== $ftp->put($filename, $filename))
	echo $filename." has been uploaded as ".$filename."\n";
else {
	$ftp->quit();
	die("Error!!\n");
}

	
//$ftp->cdup();
//	echo "<br>CD Up Ok...";




//if(!$ftp->SetType(FTP_AUTOASCII)) echo "SetType FAILS!\n";
//if(!$ftp->Passive(FALSE)) echo "Passive FAILS!\n";

/*
$ftp->chdir("apache");
$ftp->cdup();

$ftp->nlist("-la");

$filename  = "ftpweblog-102a.tar.gz";
if(FALSE !== $ftp->get($filename))
	echo $filename." has been downloaded.\n";
else {
	$ftp->quit();
	die("Error!!\n");
}
$ftp->nlist("-la");

if(FALSE !== $ftp->put($filename, "new-".$filename))
	echo $filename." has been uploaded as ".$filename.".bak\n";
else {
	$ftp->quit();
	die("Error!!\n");
}
*/
$ftp->quit();
}

function insert_error($error) {
		$sql = sprintf("INSERT INTO %s (description) VALUES (\"%s\")", "cart_error",  $error);
		mysql_query($sql);
	}
?>