<?php

require_once("db_config.php");
if (!session_id()) session_start();
error_reporting(E_ALL);
class cart_student {
	// student Information
	var $student_name="";
	var $school_name="";
	var $school_city="";
	var $school_state="";
	var $error='';
	

	function get_student($order_id) {
		$sql_check = sprintf("SELECT id FROM %s WHERE order_id = '%d'", STUDENTS, $order_id);
		if ($res_check = mysql_query($sql_check)) {
			if (mysql_num_rows($res_check) > 0 && $order_id != 0) {
				$_SESSION['student_id'] = mysql_result($res_check, 0, "id");
			} else {
				$sql_new = sprintf("INSERT INTO %s (student_name) VALUES ('')", STUDENTS);
				if (mysql_query($sql_new)) {
					$_SESSION['student_id'] = mysql_insert_id();

				} else {
					$this->error = $this->messages(1);
				}
			}
		} else {
			$this->error = $this->messages(1);
		}
	}
	
		

	// get all order rows from the DB and store them in to an array
	function get_student_orders($student_id='') {
		$student_id = ($student_id==''? $_SESSION['student_id'] : $student_id ); 
		$sql = sprintf("SELECT r.id, r.student, r.order_date, r.processed_on, r.subtotal, r.discount, r.shipping, r.total FROM %s AS r  WHERE  r.student = %d AND r.open = 'n'", 
		ORDERS, 
		$student_id);
		if ($result = mysql_query($sql)) {
			if (mysql_num_rows($result) > 0) {
				$counter = 0;
				while ($row = mysql_fetch_assoc($result)) {
					foreach($row as $key => $val) {
						$this->orders_array[$counter][$key] = $val;
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
	
// check if already an shipment record exist, if yes return the data
	function check_return_student() {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE order_id = %d", STUDENTS, $_SESSION['order_id']);
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
	
	function check_return_student_by_order($order_id) {
		$sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE order_id = '%d'", STUDENTS, $order_id);
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
	function set_student_data() {
		if ($this->check_return_student()) { // create an empty record if there is no shipment data
		$sql = sprintf("SELECT * FROM %s WHERE order_id = %d", STUDENTS, $_SESSION['order_id']);
		if ($result = mysql_query($sql)) {
			$cust_obj = mysql_fetch_object($result);
				$this->student_name = $cust_obj->student_name;
				$this->school_name = $cust_obj->school_name;
				$this->school_city = $cust_obj->school_city;
				$this->state_school = $cust_obj->school_state;
					} 
		else {
				$this->error = $this->messages(1);	}
		}
	}
	
	function set_student_data_by_order($order_id) {
		if ($this->check_return_student($order_id)) { // create an empty record if there is no shipment data
		$sql = sprintf("SELECT * FROM %s WHERE order_id = %d", STUDENTS, $order_id);
		if ($result = mysql_query($sql)) {
			$cust_obj = mysql_fetch_object($result);
				$this->student_name = $cust_obj->student_name;
				$this->school_name = $cust_obj->school_name;
				$this->school_city = $cust_obj->school_city;
				$this->state_school = $cust_obj->school_state;
					} 
		else {
				$this->error = $this->messages(1);	}
		}
	}



	function delete_student($student_id) {
		$sql = sprintf("DELETE FROM %s WHERE id = %d", STUDENTS, $student_id);
		if (mysql_query($sql)) {
			$this->error = $this->messages(15);
		} else {
			$this->error = $this->messages(1);
		}	
	}

// function to insert a new shipment record
	function insert_new_student() {
		$sql = sprintf("INSERT INTO %s (user_id, FirstName, LastName, address, address2, ZipCode, City, State, eMail, Password, Phone) VALUES (%d, %s, %s, %s, %s, %s, %s, %s)",
			STUDENTS, 
			$_SESSION['student_id'],
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
function update_student($name, $school , $city, $order_id='') {
	$sql = sprintf("UPDATE %s SET student_name = %s, school_name = %s, school_city = %s, order_id = %s WHERE id = %d", 
				STUDENTS, 
				$this->prepare_string_value($name), 
				$this->prepare_string_value($school), 
				$this->prepare_string_value($city), 
				$_SESSION['order_id'],
				$_SESSION['student_id']
				);
				
				if (mysql_query($sql)) {
					$this->error = $this->messages(56);
				} else {
					$this->error = $this->messages(1);
						}
			
	}
	
	function update_student_from_vars() {
	$sql = sprintf("UPDATE %s SET FirstName = %s, LastName = %s, address = %s, address2 = %s, ZipCode = %s, City = %s, State = %s, email = %s, phone = %s, user	 = %s WHERE id = %d", 
				STUDENTS, 
				$this->prepare_string_value($this->cust_firstname), 
				$this->prepare_string_value($this->cust_lastname), 
				$this->prepare_string_value($this->cust_address), 
				$this->prepare_string_value($this->cust_address2), 
				$this->prepare_string_value($this->cust_zipcode), 
				$this->prepare_string_value($this->cust_city), 
				$this->prepare_string_value($this->cust_state),
				$this->prepare_string_value($this->cust_email),
				$this->prepare_string_value($this->cust_phone),
				$this->prepare_string_value($this->cust_user),
				$_SESSION['student_id']);
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
}
