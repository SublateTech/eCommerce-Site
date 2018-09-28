<?php

require_once("db_config.php");
if (!session_id()) session_start();
error_reporting(E_ALL);

class cart_magazines {
	// student Information
	var $error='';
	
	var	$order_id ;  
 	var	$OPERATORID = '' ;  
  	var	$PARTNERID = '';
  	var	$TRANSACTIONID = '';
  	var	$SUSCRIBERNAME = '';
  	var	$PRIMARYADDRESS = '';
  	var	$SECONDARYADDRESS = '';
  	var	$FOREIGNADDRESS = '';
  	var	$CITY = '';
  	var	$STATE = '';
  	var	$ZIPCODE = '';
  	var	$COUNTRYCODE = ''; 
	var	$EMAILADDRESS = '';
  	var	$LISTKEY = '';
  	var	$BATCHNUMBER = ''; 
  	var	$CAGEDATE = ''; 
  	var	$VAR_PART_INFO = ''; 
  	var	$CREDITCARDTYPE = '';
  	var	$PRIVATELABELCARD  = '';
  	var	$CREDITCARDEXPIRE = '';
  	var	$CREDITCARDNUMBER  = '';
  	var	$OFFERCODE1 = '';
  	var	$Field21 = '';
  	var	$PARTNERSORDERDT = '';
  	var	$HOMETELEPHONE = '';
  	var	$ALTERNATETELEPHONE = ''; 
  	var	$Field25 = ''; 
  	var	$COUNTRYCODE1 = ''; 
  	var	$COMPANYCODE = ''; 
  	var	$BUSSINESCODE = ''; 
  	var	$Field30= '';
	
	var $magazines_array = array();
	var $magazines_array_items = array();
	var $orders_magazines_array = array();

	// constructor ...
	function cart_magazines($order_id='', $product_id='') {
		$conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_NAME, $conn);
		$this->error = "&nbsp;";
		//$this->get_magazine_by_order($order_id, $product_id);
	}
	
	
		// get all order rows from the DB and store them in to an array
	function show_ordered_rows($order_id, $product_id) {
		
		$sql = sprintf("SELECT * FROM %s  WHERE order_id = %d  AND product_id = '%s'", MAGAZINES_EXPORT, $order_id, $product_id);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->magazines_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
	}

	function show_footer()
		{
		}
		
		
	function get_magazines_by_order($order_id)
		{
		$sql = sprintf("SELECT * from cart_magazines_export as m , cart_orders as o WHERE m.order_id = o.id AND o.id = '%s'", $order_id);
		//echo $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->magazines_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
			
		}
		
	function get_orders_with_magazines()
		{
		$sql = sprintf("SELECT DISTINCT r.order_id from cart_rows as r , cart_orders as o  WHERE r.order_id = o.id And o.open='n' And LEFT(product_id,1) = 'G' And r.proccessed=' '");
		//echo $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->orders_magazines_array[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
			
		}

	function get_magazines_items($order_id)
		{
		$sql = "SELECT r.order_id, r.Product_id, r.quantity, r.price, o.customer, DATE_FORMAT(o.processed_on, '%m%d%Y') as order_date from cart_rows as r , cart_orders as o WHERE r.order_id = o.id And LEFT(r.product_id,1) = 'G' AND o.id = '".$order_id."'";
		//echo $sql;
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				unset($this->magazines_array_items);
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->magazines_array_items[$counter][$key] = $val;
					}
					$counter++;
				}
			} else {
				$this->error = $this->messages(14);
			}
		} else {
			$this->error = $this->messages(1);
		}
			
		}

		// get the number of ordered rows which belong to this customer
	function get_number_of_records($order_id, $product_id) {
		$sql = sprintf("SELECT COUNT(*) AS num FROM %s  WHERE order_id = %d AND product_id = '%s'", MAGAZINES_EXPORT, $order_id, $product_id);

		if ($result = mysql_query($sql)) {
			return mysql_result($result, 0, "num");
		} else {
			$this->error = $this->messages(1);
			return;
		}
	}

		// get the number of ordered rows which belong to this customer
	function get_number_of_items($order_id, $product_id) {
		$sql = sprintf("SELECT quantity AS num FROM %s  WHERE order_id = %d AND product_id = '%s'", ORDER_ROWS, $order_id, $product_id);

		if ($result = mysql_query($sql)) {
			return mysql_result($result, 0, "num");
		} else {
			$this->error = $this->messages(1);
			return;
		}
	}

	
	function get_magazine_by_order($order_id='', $product_id='')
		 {
		$sql_check = sprintf("SELECT id FROM %s WHERE order_id = '%d' And product_id = '%s'", MAGAZINES_EXPORT, $order_id, $product_id);
		if ($res_check = mysql_query($sql_check) ) {
			if (mysql_num_rows($res_check) > 0) {
				$_SESSION['magazine_id'] = mysql_result($res_check, 0, "id");
				return $_SESSION['magazine_id'];
			} else {
				$sql_new = sprintf("INSERT INTO %s (order_id, product_id) VALUES (%d, '%s')", MAGAZINES_EXPORT, $order_id, $product_id);
				if (mysql_query($sql_new)) {
					$_SESSION['magazine_id'] = mysql_insert_id();
					return $_SESSION['magazine_id'];
				} else {
					$this->error = $this->messages(1);
					return 0;
				}
			}
		} else {
			$this->error = $this->messages(1);
			return 0;
		}
	}



	function get_magazine($magazine=0)
		 {
		$sql_check = sprintf("SELECT id FROM %s WHERE id = '%d'", MAGAZINES_EXPORT, $magazine);
		if ($res_check = mysql_query($sql_check) ) {
			if (mysql_num_rows($res_check) > 0 && $magazine != 0) {
				$_SESSION['magazine_id'] = mysql_result($res_check, 0, "id");
				return $_SESSION['magazine_id'];
			} else {
				$sql_new = sprintf("INSERT INTO %s (order_id) VALUES (0)", MAGAZINES_EXPORT);
				if (mysql_query($sql_new)) {
					$_SESSION['magazine_id'] = mysql_insert_id();
					return $_SESSION['magazine_id'];
				} else {
					$this->error = $this->messages(1);
					return 0;
				}
			}
		} else {
			$this->error = $this->messages(1);
			return 0;
		}
	}
	
	function check_magazine($order_id, $product_id)
		 {
		$sql_check = sprintf("SELECT id FROM %s WHERE order_id = '%d' And product_id='%s'", MAGAZINES_EXPORT, $order_id, $product_id);
		if ($res_check = mysql_query($sql_check) ) {
			if (mysql_num_rows($res_check) > 0 ) {
				$_SESSION['magazine_id'] = mysql_result($res_check, 0, "id");
				return $_SESSION['magazine_id'];
			} else {
				$sql_new = sprintf("INSERT INTO %s (order_id, product_id) VALUES (%d, '%s')", MAGAZINES_EXPORT, $order_id, $product_id);
				if (mysql_query($sql_new)) {
					$_SESSION['magazine_id'] = mysql_insert_id();
					return $_SESSION['magazine_id'];
				} else {
					$this->error = $this->messages(1);
					return 0;
				}
			}
		} else {
			$this->error = $this->messages(1);
			return 0;
		}
	}
		
// check if already an shipment record exist, if yes return the data
	function check_return_magazine($id=0) {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE id = '%d'", MAGAZINES_EXPORT, $id);
		if ($result = mysql_query($sql)) {
			if (mysql_result($result, 0, "test") == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			$this->error = $this->messages(1);
			return false; 
		}
	}	
	

// read the current shipment data and set the variabels
	function set_magazine_data($magazine_no = 0) {
		if ($this->check_return_magazine($magazine_no)) { // create an empty record if there is no shipment data
		$sql = sprintf("SELECT * FROM %s WHERE id = '%d'", MAGAZINES_EXPORT, $magazine_no);
		//echo $sql;
		if ($result = mysql_query($sql)) {
			$obj = mysql_fetch_object($result);
					
 				$this->order_id				= 	$obj->order_id;
				$this->product_id			=	$obj->product_id;
 				$this->OPERATORID			=	$obj->OPERATORID;  
  				$this->PARTNERID			=	$obj->PARTNERID;
  				$this->TRANSACTIONID		=	$obj->TRANSACTIONID;
  				$this->SUSCRIBERNAME		=	$obj->SUSCRIBERNAME;
  				$this->PRIMARYADDRESS		=	$obj->PRIMARYADDRESS;
  				$this->SECONDARYADDRESS		=	$obj->SECONDARYADDRESS;
  				$this->FOREIGNADDRESS		=	$obj->FOREIGNADDRESS;
  				$this->CITY					=	$obj->CITY;
  				$this->STATE				=	$obj->STATE;
  				$this->ZIPCODE				=	$obj->ZIPCODE;
  				$this->COUNTRYCODE			=	$obj->COUNTRYCODE; 
				$this->EMAILADDRESS			=	$obj->EMAILADDRESS;
  				$this->LISTKEY				=	$obj->LISTKEY;
  				$this->BATCHNUMBER			=	$obj->BATCHNUMBER; 
  				$this->CAGEDATE				=	$obj->CAGEDATE; 
  				$this->VAR_PART_INFO		=	$obj->VAR_PART_INFO; 
  				$this->CREDITCARDTYPE		=	$obj->CREDITCARDTYPE;
  				$this->PRIVATELABELCARD		=	$obj->PRIVATELABELCARD;
  				$this->CREDITCARDEXPIRE		=	$obj->CREDITCARDEXPIRE;
  				$this->CREDITCARDNUMBER		=	$obj->CREDITCARDNUMBER;
  				$this->OFFERCODE1			=	$obj->OFFERCODE1;
  				$this->Field21				=	$obj->Field21;
  				$this->PARTNERSORDERDT		=	$obj->PARTNERSORDERDT;
  				$this->HOMETELEPHONE		=	$obj->HOMETELEPHONE;
  				$this->ALTERNATETELEPHONE	=	$obj->ALTERNATETELEPHONE; 
  				$this->Field25				=	$obj->Field25;
  				$this->COUNTRYCODE1			=	$obj->COUNTRYCODE1; 
  				$this->COMPANYCODE			=	$obj->COMPANYCODE; 
  				$this->BUSSINESCODE			=	$obj->BUSSINESCODE; 
  				$this->Field30 				=	$obj->Field30;
				
					} 
		else {
				$this->error = $this->messages(1);	}
		}
	}

	function set_magazine_data_by_order($order_id, $product_id) {
		//if ($this->check_return_magazine($magazine_no)) { // create an empty record if there is no shipment data
		if (1) {	
		$sql = sprintf("SELECT * FROM %s WHERE order_id = %d And product_id = '%s'", MAGAZINES_EXPORT_FILE, $order_id, $product_id);
		if ($result = mysql_query($sql)) {
			$obj = mysql_fetch_object($result);
					
 				$this->order_id				= 	$obj->order_id;
				$this->product_id			=	$obj->product_id;
 				$this->OPERATORID			=	$obj->OPERATORID;  
  				$this->PARTNERID			=	$obj->PARTNERID;
  				$this->TRANSACTIONID		=	$obj->TRANSACTIONID;
  				$this->SUSCRIBERNAME		=	$obj->SUSCRIBERNAME;
  				$this->PRIMARYADDRESS		=	$obj->PRIMARYADDRESS;
  				$this->SECONDARYADDRESS		=	$obj->SECONDARYADDRESS;
  				$this->FOREIGNADDRESS		=	$obj->FOREIGNADDRESS;
  				$this->CITY					=	$obj->CITY;
  				$this->STATE				=	$obj->STATE;
  				$this->ZIPCODE				=	$obj->ZIPCODE;
  				$this->COUNTRYCODE			=	$obj->COUNTRYCODE; 
				$this->EMAILADDRESS			=	$obj->EMAILADDRESS;
  				$this->LISTKEY				=	$obj->LISTKEY;
  				$this->BATCHNUMBER			=	$obj->BATCHNUMBER; 
  				$this->CAGEDATE				=	$obj->CAGEDATE; 
  				$this->VAR_PART_INFO		=	$obj->VAR_PART_INFO; 
  				$this->CREDITCARDTYPE		=	$obj->CREDITCARDTYPE;
  				$this->PRIVATELABELCARD		=	$obj->PRIVATELABELCARD;
  				$this->CREDITCARDEXPIRE		=	$obj->CREDITCARDEXPIRE;
  				$this->CREDITCARDNUMBER		=	$obj->CREDITCARDNUMBER;
  				$this->OFFERCODE1			=	$obj->OFFERCODE1;
  				$this->Field21				=	$obj->Field21;
  				$this->PARTNERSORDERDT		=	$obj->PARTNERSORDERDT;
  				$this->HOMETELEPHONE		=	$obj->HOMETELEPHONE;
  				$this->ALTERNATETELEPHONE	=	$obj->ALTERNATETELEPHONE; 
  				$this->Field25				=	$obj->Field25;
  				$this->COUNTRYCODE1			=	$obj->COUNTRYCODE1; 
  				$this->COMPANYCODE			=	$obj->COMPANYCODE; 
  				$this->BUSSINESCODE			=	$obj->BUSSINESCODE; 
  				$this->Field30 				=	$obj->Field30;
				
					} 
		else {
				$this->error = $this->messages(1);	}
		}
	}


	function prepare_text_to_send()
		{
		
		$string = '';
		$string .= $this->add_spaces($this->OPERATORID, 3);  
  		$string .= $this->add_spaces($this->PARTNERID, 5);
  		$string .= $this->add_spaces($this->TRANSACTIONID, 3);
  		$string .= $this->add_spaces($this->SUSCRIBERNAME, 30);
  		$string .= $this->add_spaces($this->PRIMARYADDRESS, 30);
  		$string .= $this->add_spaces($this->SECONDARYADDRESS,30);
  		$string .= $this->add_spaces($this->FOREIGNADDRESS, 30);
  		$string .= $this->add_spaces($this->CITY, 13);
  		$string .= $this->add_spaces($this->STATE, 2);
  		$string .= $this->add_spaces($this->ZIPCODE, 6);
  		$string .= $this->add_spaces($this->COUNTRYCODE, 3); 
		$string .= $this->add_spaces($this->EMAILADDRESS, 50);
  		$string .= $this->add_spaces($this->LISTKEY, 6);
  		$string .= $this->add_spaces($this->BATCHNUMBER, 5); 
  		$string .= $this->add_spaces($this->CAGEDATE, 8); 
  		$string .= $this->add_spaces($this->VAR_PART_INFO,60); 
  		$string .= $this->add_spaces($this->CREDITCARDTYPE, 1);
  		$string .= $this->add_spaces($this->PRIVATELABELCARD,6);
  		$string .= $this->add_spaces($this->CREDITCARDEXPIRE, 4);
  		$string .= $this->add_spaces($this->CREDITCARDNUMBER,20);
  		$string .= $this->add_spaces($this->OFFERCODE1,5);
  		$string .= $this->add_spaces($this->Field21, 105); 
  		$string .= $this->add_spaces($this->PARTNERSORDERDT, 8); 
  		$string .= $this->add_spaces($this->HOMETELEPHONE, 10);
  		$string .= $this->add_spaces($this->ALTERNATETELEPHONE, 10); 
  		$string .= $this->add_spaces($this->Field25, 30); 
  		$string .= $this->add_spaces($this->COUNTRYCODE1, 1); 
  		$string .= $this->add_spaces($this->COMPANYCODE, 1); 
  		$string .= $this->add_spaces($this->BUSSINESCODE, 1); 
  		$string .= $this->add_spaces($this->Field30, 334);
		return $string;
		}
	function delete_magazine($magazine_id) {
		$sql = sprintf("DELETE FROM %s WHERE id = %d", MAGAZINE_EXPORT, $magazine_id);
		if (mysql_query($sql)) {
			$this->error = $this->messages(15);
		} else {
			$this->error = $this->messages(1);
		}	
	}

// function to insert a new shipment record
	function insert_new_magazine() {
		$sql = sprintf("INSERT INTO %s (user_id, FirstName, LastName, address, address2, ZipCode, City, State, eMail, Password, Phone) VALUES (%d, %s, %s, %s, %s, %s, %s, %s)",
			MAGAZINE_EXPORT, 
			$_SESSION['magazine_id'],
			$this->prepare_string_value($this->cust_user), 
			$this->prepare_string_value($this->cust_firstname), 
			$this->prepare_string_value($this->cust_lastname), 
			$this->prepare_string_value($this->cust_address), 
			$this->prepare_string_value($this->cust_address2), 
			$this->prepare_string_value($this->cust_zipcode), 
			$this->prepare_string_value($this->cust_city), 
			$this->prepare_string_value($this->cust_state),
			$this->prepare_string_value($this->cust_email),
			$this->prepare_string_value($this->cust_password),
			$this->prepare_string_value($this->cust_phone));
						
		if (!mysql_query($sql)) {
			$this->error = $this->messages(1);
		}
	}
function update_magazine(
	$order_id, 
	$product_id,
 	$OPERATORID,  
  	$PARTNERID,
  	$TRANSACTIONID,
  	$SUSCRIBERNAME,
  	$PRIMARYADDRESS,
  	$SECONDARYADDRESS,
  	$FOREIGNADDRESS,
  	$CITY,
  	$STATE,
  	$ZIPCODE,
  	$COUNTRYCODE, 
	$EMAILADDRESS,
  	$LISTKEY,
  	$BATCHNUMBER, 
  	$CAGEDATE, 
  	$VAR_PART_INFO, 
  	$CREDITCARDTYPE,
  	$PRIVATELABELCARD,
  	$CREDITCARDEXPIRE,
  	$CREDITCARDNUMBER,
  	$OFFERCODE1,
  	$Field21,
  	$PARTNERSORDERDT,
  	$HOMETELEPHONE,
  	$ALTERNATETELEPHONE, 
  	$Field25, 
  	$COUNTRYCODE1, 
  	$COMPANYCODE, 
  	$BUSSINESCODE, 
  	$Field30
) 

	{
		$sql = sprintf("UPDATE %s SET OPERATORID = '%s',  
  		PARTNERID = '%s' ,
  		TRANSACTIONID = '%s',
  		SUSCRIBERNAME = '%s',
  		PRIMARYADDRESS = '%s',
  		SECONDARYADDRESS = '%s',
  		FOREIGNADDRESS = '%s',
  		CITY = '%s',
  		STATE = '%s',
  		ZIPCODE = '%s' ,
  		COUNTRYCODE = '%s', 
		EMAILADDRESS = '%s',
  		LISTKEY = '%s',
  		BATCHNUMBER = '%s', 
  		CAGEDATE = '%s', 
  		VAR_PART_INFO = '%s', 
  		CREDITCARDTYPE = '%s' ,
  		PRIVATELABELCARD  = '%s' ,
  		CREDITCARDEXPIRE = '%s' ,
  		CREDITCARDNUMBER  = '%s' ,
  		OFFERCODE1 = '%s' ,
  		Field21 = '%s' ,
  		PARTNERSORDERDT = '%s' ,
  		HOMETELEPHONE = '%s' ,
  		ALTERNATETELEPHONE = '%s', 
  		Field25 = '%s', 
  		COUNTRYCODE1 = '%s', 
  		COMPANYCODE = '%s', 
  		BUSSINESCODE = '%s', 
  		Field30 = '%s' Where order_id = '%d' And product_id='%s'",
		
		MAGAZINES_EXPORT_FILE, 
		$OPERATORID,  
  		$PARTNERID ,
  		$TRANSACTIONID,
  		$SUSCRIBERNAME,
  		$PRIMARYADDRESS,
  		$SECONDARYADDRESS,
  		$FOREIGNADDRESS,
  		$CITY,
  		$STATE,
  		$ZIPCODE ,
  		$COUNTRYCODE, 
		$EMAILADDRESS,
  		$LISTKEY,
  		$BATCHNUMBER, 
  		$CAGEDATE, 
  		$VAR_PART_INFO, 
  		$CREDITCARDTYPE ,
  		$PRIVATELABELCARD ,
  		$CREDITCARDEXPIRE ,
  		$CREDITCARDNUMBER,
  		$OFFERCODE1,
  		$Field21, 
  		$PARTNERSORDERDT, 
  		$HOMETELEPHONE ,
  		$ALTERNATETELEPHONE, 
  		$Field25, 
  		$COUNTRYCODE1, 
  		$COMPANYCODE, 
  		$BUSSINESCODE, 
  		$Field30,
		$order_id,
		$product_id
		); 
		//echo $sql;
				
			if (mysql_query($sql)) {
				$this->error = $this->messages(56);
			} else {
				$this->error = $this->messages(1);
			}
			
	}
	function update_magazine_data($order_id, $product_id)
	{
		$sql = sprintf("UPDATE %s SET proccessed = 'M' WHERE order_id = %d And product_id='%s'", 'cart_rows', $order_id,  $product_id);
		if (mysql_query($sql)) {
				$this->error = $this->messages(12);
			} else {
				$this->error = $this->messages(1);
		}
	}

	
	function save_file($filepath, $string)
		{
			$string .= "\r\n";
			$handle = fopen($filepath, "a");
			fputs($handle, $string , strlen($string));
			fclose($handle);
		}
	
	function add_spaces($field, $number)
		{
			//echo "'".$number."->". strlen($field . str_repeat(' ', $number - strlen($field)))."'<br>";
			//return $field . str_repeat('&nbsp;', $number - strlen($field));
			return $field . str_repeat(' ', $number - strlen($field));
		}
		 
	function update_magazine_from_vars($id='') {
		$sql = sprintf("UPDATE %s SET OPERATORID = '%s',  
  		PARTNERID = '%s' ,
  		TRANSACTIONID = '%s',
  		SUSCRIBERNAME = '%s',
  		PRIMARYADDRESS = '%s',
  		SECONDARYADDRESS = '%s',
  		FOREIGNADDRESS = '%s',
  		CITY = '%s',
  		STATE = '%s',
  		ZIPCODE = '%s' ,
  		COUNTRYCODE = '%s', 
		EMAILADDRESS = '%s',
  		LISTKEY = '%s',
  		BATCHNUMBER = '%s', 
  		CAGEDATE = '%s', 
  		VAR_PART_INFO = '%s', 
  		CREDITCARDTYPE = '%s' ,
  		PRIVATELABELCARD  = '%s' ,
  		CREDITCARDEXPIRE = '%s' ,
  		CREDITCARDNUMBER  = '%s' ,
  		OFFERCODE1 = '%s' ,
  		Field21 = '%s' ,
  		PARTNERSORDERDT = '%s' ,
  		HOMETELEPHONE = '%s' ,
  		ALTERNATETELEPHONE = '%s', 
  		Field25 = '%s', 
  		COUNTRYCODE1 = '%s', 
  		COMPANYCODE = '%s', 
  		BUSSINESCODE = '%s', 
  		Field30 = '%s' Where id = '%d'",
		
		MAGAZINES_EXPORT, 
		$this->OPERATORID,  
  		$this->PARTNERID ,
  		$this->TRANSACTIONID,
  		$this->SUSCRIBERNAME,
  		$this->PRIMARYADDRESS,
  		$this->SECONDARYADDRESS,
  		$this->FOREIGNADDRESS,
  		$this->CITY,
  		$this->STATE,
  		$this->ZIPCODE ,
  		$this->COUNTRYCODE, 
		$this->EMAILADDRESS,
  		$this->LISTKEY,
  		$this->BATCHNUMBER, 
  		$this->CAGEDATE, 
  		$this->VAR_PART_INFO, 
  		$this->CREDITCARDTYPE ,
  		$this->PRIVATELABELCARD ,
  		$this->CREDITCARDEXPIRE ,
  		$this->CREDITCARDNUMBER,
  		$this->OFFERCODE1,
  		$this->Field21, 
  		$this->PARTNERSORDERDT, 
  		$this->HOMETELEPHONE ,
  		$this->ALTERNATETELEPHONE, 
  		$this->Field25, 
  		$this->COUNTRYCODE1, 
  		$this->COMPANYCODE, 
  		$this->BUSSINESCODE, 
  		$this->Field30,
		$id
		); 
		//echo $sql;
				if (mysql_query($sql)) {
					$this->error = $this->messages(56);
				} else {
					$this->error = $this->messages(1);
						}
			
	}

	// format a decimal number into an euro amount 
	// $encoding is used for the browser and 
	function format_value($value, $encoding = true) {
		if ($encoding) {
			$curr = (ord(CURRENCY) == "128") ? "&#8364;" : htmlentities(CURRENCY);
		} else {
			$curr= CURRENCY;
		}
		$formatted = $curr." ".number_format($value, 2, ".", ",");
		return $formatted;
	}
	// simple string preperation to prepend SQL injections
	function prepare_string_value($value) {
		$new_value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;
		$new_value = ($value != "") ? "'".trim($value)."'" : "''";
		return $new_value;
	}

	function messages($number) {
	}
	
	function update_magazine_by_order(
	$id, 
	$order_id, 
	$product_id,
 	$OPERATORID,  
  	$PARTNERID,
  	$TRANSACTIONID,
  	$SUSCRIBERNAME,
  	$PRIMARYADDRESS,
  	$SECONDARYADDRESS,
  	$FOREIGNADDRESS,
  	$CITY,
  	$STATE,
  	$ZIPCODE,
  	$COUNTRYCODE, 
	$EMAILADDRESS,
  	$LISTKEY,
  	$BATCHNUMBER, 
  	$CAGEDATE, 
  	$VAR_PART_INFO, 
  	$CREDITCARDTYPE,
  	$PRIVATELABELCARD,
  	$CREDITCARDEXPIRE,
  	$CREDITCARDNUMBER,
  	$OFFERCODE1,
  	$Field21,
  	$PARTNERSORDERDT,
  	$HOMETELEPHONE,
  	$ALTERNATETELEPHONE, 
  	$Field25, 
  	$COUNTRYCODE1, 
  	$COMPANYCODE, 
  	$BUSSINESCODE, 
  	$Field30
) 

	{
		$sql = sprintf("UPDATE %s SET OPERATORID = '%s',  
  		PARTNERID = '%s' ,
  		TRANSACTIONID = '%s',
  		SUSCRIBERNAME = '%s',
  		PRIMARYADDRESS = '%s',
  		SECONDARYADDRESS = '%s',
  		FOREIGNADDRESS = '%s',
  		CITY = '%s',
  		STATE = '%s',
  		ZIPCODE = '%s' ,
  		COUNTRYCODE = '%s', 
		EMAILADDRESS = '%s',
  		LISTKEY = '%s',
  		BATCHNUMBER = '%s', 
  		CAGEDATE = '%s', 
  		VAR_PART_INFO = '%s', 
  		CREDITCARDTYPE = '%s' ,
  		PRIVATELABELCARD  = '%s' ,
  		CREDITCARDEXPIRE = '%s' ,
  		CREDITCARDNUMBER  = '%s' ,
  		OFFERCODE1 = '%s' ,
  		Field21 = '%s' ,
  		PARTNERSORDERDT = '%s' ,
  		HOMETELEPHONE = '%s' ,
  		ALTERNATETELEPHONE = '%s', 
  		Field25 = '%s', 
  		COUNTRYCODE1 = '%s', 
  		COMPANYCODE = '%s', 
  		BUSSINESCODE = '%s', 
  		Field30 = '%s' Where order_id = '%d' And product_id='%s'",
		
		MAGAZINES_EXPORT, 
		$OPERATORID,  
  		$PARTNERID ,
  		$TRANSACTIONID,
  		$SUSCRIBERNAME,
  		$PRIMARYADDRESS,
  		$SECONDARYADDRESS,
  		$FOREIGNADDRESS,
  		$CITY,
  		$STATE,
  		$ZIPCODE ,
  		$COUNTRYCODE, 
		$EMAILADDRESS,
  		$LISTKEY,
  		$BATCHNUMBER, 
  		$CAGEDATE, 
  		$VAR_PART_INFO, 
  		$CREDITCARDTYPE ,
  		$PRIVATELABELCARD ,
  		$CREDITCARDEXPIRE ,
  		$CREDITCARDNUMBER,
  		$OFFERCODE1,
  		$Field21, 
  		$PARTNERSORDERDT, 
  		$HOMETELEPHONE ,
  		$ALTERNATETELEPHONE, 
  		$Field25, 
  		$COUNTRYCODE1, 
  		$COMPANYCODE, 
  		$BUSSINESCODE, 
  		$Field30,
		$order_id,
		$product_id
		
		); 
		//echo $sql;
				
			if (mysql_query($sql)) {
				$this->error = $this->messages(56);
			} else {
				$this->error = $this->messages(1);
			}
			
	}
	
	function get_magazine_by_order_file($order_id='', $product_id='')
		 {
		$sql_check = sprintf("SELECT id FROM %s WHERE order_id = '%d' And product_id = '%s'", MAGAZINES_EXPORT_FILE, $order_id, $product_id);
		if ($res_check = mysql_query($sql_check) ) {
			if (mysql_num_rows($res_check) > 0) {
				$_SESSION['magazine_id'] = mysql_result($res_check, 0, "id");
				return $_SESSION['magazine_id'];
			} else {
				$sql_new = sprintf("INSERT INTO %s (order_id, product_id) VALUES (%d, '%s')", MAGAZINES_EXPORT_FILE, $order_id, $product_id);
				if (mysql_query($sql_new)) {
					$_SESSION['magazine_id'] = mysql_insert_id();
					return $_SESSION['magazine_id'];
				} else {
					$this->error = $this->messages(1);
					return 0;
				}
			}
		} else {
			$this->error = $this->messages(1);
			return 0;
		}
	}
	
	function delete_magazine_file() {
		$sql = sprintf("DELETE FROM %s ", MAGAZINES_EXPORT_FILE);
		if (mysql_query($sql)) {
			$this->error = $this->messages(15);
		} else {
			$this->error = $this->messages(1);
		}	
	}


}
